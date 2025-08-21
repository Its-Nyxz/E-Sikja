<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MyComplaintController extends Controller
{
    protected string $pathUpload;

    public function __construct()
    {
        if (Auth::user()->role != 'masyarakat') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $this->pathUpload = 'uploads/complaints/';
        $this->pathPublic = public_path($this->pathUpload);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->status;
            $query = Complaint::where('user_id', Auth::user()->id);
            if ($status != 'semua') {
                $query = $query->where('status', $status);
            }
            $query = $query->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->addColumn('status', function($row) {
                    $badge = '<span class="badge bg-';
                    switch ($row->status) {
                        case 'Diajukan':
                            $badge .= 'primary';
                            break;
                        case 'Diproses':
                            $badge .= 'warning';
                            break;
                        case 'Selesai':
                            $badge .= 'success';
                            break;
                        case 'Ditolak':
                            $badge .= 'danger';
                            break;
                    }
                    $badge .= ' text-white">' . $row->status . '</span>';

                    return $badge;
                })
                ->addColumn('action', function($row) {
                    $actionBtn = '<div class="btn-group" role="group" aria-label="Basic example">';
                    $actionBtn .= '<a href="javascript:void(0)" class="btn btn-info btn-sm" data-id="'.$row->id.'"><span class="fa fa-eye"></span></a>';
                    if ($row->status == 'Diajukan') {
                        $actionBtn .= '<a href="'.route('pengaduan-saya.edit', $row->id).'" class="btn btn-warning btn-sm"><span class="fa fa-edit"></span></a>';
                        $actionBtn .= '<form action="'.route('pengaduan-saya.destroy', $row->id).'" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pengaduan ini?\');">
                                        '.csrf_field().method_field('DELETE').'
                                        <button type="submit" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                       </form>';
                    }
                    $actionBtn .= '</div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $data = [
            'title' => 'Pengaduan Saya'
        ];

        return view('cms.my-complaint.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Buat Pengaduan Baru'
        ];

        return view('cms.my-complaint.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $code = "CMP/".date('y')."/".date('m')."/".date('d');
            $complaintLast = Complaint::where('code', 'like', "$code%")->latest()->first();
            $lastNumber = $complaintLast ? intval(substr($complaintLast->code, -3)) + 1 : 1;
            $code .= '/'.str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

            $complaint = new Complaint();
            $complaint->code = $code;
            $complaint->title = $validated['title'];
            $complaint->description = $validated['description'];
            $complaint->location = $validated['location'];
            $complaint->date = now();
            $complaint->status = 'Diajukan';
            $complaint->user_id = auth()->id();
            $complaint->histories = json_encode([
                [
                    'user_id' => auth()->id(),
                    'status' => 'Diajukan',
                    'date' => now(),
                    'note' => 'Pengaduan berhasil dibuat'
                ]
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
                $image->move($this->pathPublic, $imageName);
                $complaint->image = $this->pathUpload . $imageName;
            }



            $complaint->save();

            $operators = User::where('role', 'Operator')->get();

            foreach ($operators as $operator) {
                Notification::create([
                    'user_id' => $operator->id,
                    'type' => 'Pengaduan',
                    'title' => 'Pengaduan Baru',
                    'text' => 'Pengaduan baru telah dibuat oleh ' . auth()->user()->name,
                    'link' => 'data-pengaduan/verifikasi-operator/' . $complaint->id
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Pengaduan berhasil dibuat'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $complaint = Auth::user()->complaints()->findOrFail($id);
        $histories = json_decode($complaint->histories, true);
        
        // Format histories with user names
        $formattedHistories = [];
        foreach ($histories as $history) {
            $user = User::find($history['user_id']);
            $formattedHistories[] = [
                'user_name' => $user ? $user->name : 'Unknown',
                'status' => $history['status'],
                'date' => date('d-m-Y H:i', strtotime($history['date'])),
                'note' => $history['note']
            ];
        }
        
        return response()->json([
            'code' => $complaint->code,
            'title' => $complaint->title,
            'reporter_name' => $complaint->user->name,
            'date' => date('d-m-Y H:i', strtotime($complaint->date)),
            'location' => $complaint->location,
            'status' => $complaint->status,
            'description' => $complaint->description,
            'image' => $complaint->image ? asset( $complaint->image) : null,
            'histories' => $formattedHistories
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Pengaduan',
            'complaint' => Auth::user()->complaints()->findOrFail($id)
        ];

        return response()->json([
            'csrf_token' => csrf_token(),
            'title' => $data['title'],
            'complaint' => $data['complaint']
        ]);


        // return view('cms.my-complaint.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $complaint = Auth::user()->complaints()->findOrFail($id);
            
            if ($complaint->status != 'Diajukan') {
                return redirect()->back()
                    ->with('error', 'Pengaduan tidak dapat diubah karena sudah diproses');
            }

            $complaint->title = $validated['title'];
            $complaint->description = $validated['description'];
            $complaint->location = $validated['location'];

             if ($request->hasFile('image')) {
                if ($complaint->image) {
                    $oldImagePath = public_path($information->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                $image = $request->file('image');
                $imageName = Str::random(32) . '.' . $image->getClientOriginalExtension();
                $image->move($this->pathPublic, $imageName);
                $complaint->image = $pathUpload . $imageName;
            }

            $histories = json_decode($complaint->histories, true);
            $histories[] = [
                'user_id' => auth()->id(),
                'status' => 'Diajukan',
                'date' => now(),
                'note' => 'Pengaduan berhasil diperbarui'
            ];
            $complaint->histories = json_encode($histories);

            $complaint->save();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Pengaduan berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $complaint = Auth::user()->complaints()->findOrFail($id);
            
            if ($complaint->status != 'Diajukan') {
                return redirect()->back()
                    ->with('error', 'Pengaduan tidak dapat dihapus karena sudah diproses');
            }

            $complaint->delete();
            DB::commit();
            return redirect()->route('pengaduan-saya.index')
                ->with('success', 'Pengaduan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function checkStatus(Request $request)
    {
        $nomorPengaduan = $request->nomor_pengaduan;
        
        if (!$nomorPengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor pengaduan tidak ditemukan'
            ]);
        }

        $complaint = Auth::user()->complaints()->where('code', $nomorPengaduan)->first();

        if (!$complaint) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan tidak ditemukan'
            ]);
        }
        $histories = json_decode($complaint->histories, true);

        $statusMessage = '';
        $details = '';

        switch($complaint->status) {
            case 'Diajukan':
                $statusMessage = 'Pengaduan Anda sedang dalam proses verifikasi';
                break;
            case 'Diproses':
                $statusMessage = 'Pengaduan Anda sedang diproses';
                $details = 'Tim kami sedang menangani pengaduan Anda';
                break;
            case 'Selesai':
                $statusMessage = 'Pengaduan Anda telah selesai diproses';
                $details = 'Terima kasih telah melaporkan pengaduan';
                break;
            case 'Ditolak':
                $statusMessage = 'Pengaduan Anda ditolak';
                $details = $complaint->rejection_reason ?? 'Pengaduan tidak memenuhi kriteria';
                break;
            default:
                $statusMessage = 'Status tidak diketahui';
        }

        return response()->json([
            'success' => true,
            'status' => strtolower($complaint->status),
            'message' => $statusMessage,
            'details' => $details,
            'pengaduan' => [
                'id' => $complaint->id,
                'code' => $complaint->code,
                'title' => $complaint->title,
                'created_at' => $complaint->created_at->format('d M Y H:i')
            ],
            'history' => $histories
        ]);
    }
}

