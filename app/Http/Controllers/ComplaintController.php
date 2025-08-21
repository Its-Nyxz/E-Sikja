<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Notification;
use Yajra\DataTables\Facades\DataTables;

class ComplaintController extends Controller
{
    public function __construct()
    {
        if (Auth::user()->role == 'masyarakat') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Complaint::with(['user'])
                ->when($request->status && $request->status != 'semua', function($q) use ($request) {
                    return $q->where('status', $request->status);
                });

            if (Auth::user()->role == 'admin') {
                $query = $query->whereIn('status', ['Diproses', 'Ditolak', 'Selesai']);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('status', function($row) {
                    $badge = '<span class="badge bg-';
                    switch ($row->status) {
                        case 'Diajukan':
                            $badge .= 'warning';
                            break;
                        case 'Diproses':
                            $badge .= 'primary';
                            break;
                        case 'Ditolak':
                            $badge .= 'danger';
                            break;
                        case 'Selesai':
                            $badge .= 'success';
                            break;
                    }
                    $badge .= '">'.$row->status.'</span>';
                    return $badge;
                })
                ->editColumn('created_at', function($row) {
                    return date('d-m-Y H:i', strtotime($row->created_at));
                })
                ->addColumn('action', function($row) {
                    $actionBtn = '';
                    
                    if ($row->status == 'Diajukan' || ($row->status == 'Diproses' && Auth::user()->role == 'admin')) {
                        $actionBtn = '<a href="'.route('data-pengaduan.verifikasi-'.Auth::user()->role, $row->id).'" class="btn btn-sm btn-primary">
                            <i class="fas fa-check"></i> Verifikasi
                        </a>';
                    }
                    
                    $actionBtn .= ' <button type="button" class="btn btn-sm btn-info btn-detail" data-id="'.$row->id.'">
                        <i class="fas fa-eye"></i> Detail
                    </button>';
                    
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $data = [
            'title' => 'Data Pengaduan'
        ];

        return view('cms.complaint.index', $data);
    }

    public function verifikasiOperator($id){
        if(Auth::user()->role != 'operator'){
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $complaint = Complaint::with('user')->findOrFail($id);
        // dd(json_decode($complaint->histories));
        $data = [
            'title' => 'Verifikasi Operator',
            'complaint' => $complaint
        ];
        return view('cms.complaint.verifikasi-operator', $data);
    }

    public function verifikasiAdmin($id){
        // dd($id, Auth::user()->role);
        if(Auth::user()->role != 'admin'){
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $complaint = Complaint::with('user')->findOrFail($id);
        $data = [
            'title' => 'Verifikasi Admin',
            'complaint' => $complaint
        ];
        return view('cms.complaint.verifikasi-admin', $data);
    }

    public function verifikasiProcess(Request $request, $id)
    {
        if(Auth::user()->role != 'operator'){
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $request->validate([
            'status' => 'required|in:Diproses,Ditolak',
            'notes' => 'nullable|string|min:10'
        ]);

        DB::beginTransaction();
        try {
            $complaint = Complaint::findOrFail($id);
            // Get existing histories
            $histories = json_decode($complaint->histories ?? '[]', true);
            
            // Add new history
            $histories[] = [
                'user_id' => Auth::id(),
                'status' => $request->status,
                'date' => now()->format('Y-m-d H:i:s'),
                'note' => "Pengaduan ($request->status == 'Ditolak' ?? 'diverifikasi')  oleh " . Auth::user()->name . ($request->notes ? ". Catatan: " . $request->notes : "")
            ];

            // Update complaint
            $complaint->update([
                'status' => $request->status,
                'histories' => json_encode($histories)
            ]);

            if ($request->status == 'Diproses') {
                $admins = User::where('role', 'admin')->get();

                foreach ($admins as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'title' => 'Pengaduan Baru',
                        'text' => 'Pengaduan baru telah diverifikasi oleh ' . Auth::user()->name,
                        'type' => 'Pengaduan',
                        'link' => 'data-pengaduan/verifikasi-admin/' . $complaint->id
                    ]);
                }
            }else{
                // Notify the user who made the complaint
                Notification::create([
                    'user_id' => $complaint->user_id,
                    'title' => "Pengaduan $request->status",
                    'text' => "Pengaduan Anda telah $request->status oleh ".Auth::user()->name.". Catatan: " . ($request->notes ?? 'Tidak ada catatan'),
                    'type' => 'Pengaduan',
                    'link' => 'pengaduan-saya/show/' . $complaint->id
                ]);
            }

            

            DB::commit();
            
            return redirect()->route('data-pengaduan.index')
                ->with('success', 'Pengaduan berhasil diverifikasi');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }

    public function verifikasiAdminProcess(Request $request, $id)
    {
        if(Auth::user()->role != 'admin'){
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $request->validate([
            'status' => 'required|in:Selesai,Ditolak',
            'notes' => 'nullable|string|min:10'
        ]);

        DB::beginTransaction();
        try {
            $complaint = Complaint::findOrFail($id);
            
            // Get existing histories
            $histories = json_decode($complaint->histories ?? '[]', true);
            
            // Add new history
            $histories[] = [
                'user_id' => Auth::id(),
                'status' => $request->status,
                'date' => now()->format('Y-m-d H:i:s'),
                'note' => "Pengaduan diverifikasi oleh admin " . Auth::user()->name . ($request->notes ? ". Catatan: " . $request->notes : "")
            ];

            // Update complaint
            $complaint->update([
                'status' => $request->status,
                'histories' => json_encode($histories)
            ]);

            // Notify the user who made the complaint
            Notification::create([
                'user_id' => $complaint->user_id,
                'title' => 'Status Pengaduan Diperbarui',
                'text' => 'Pengaduan Anda telah ' . strtolower($request->status) . ' oleh admin',
                'type' => 'Pengaduan',
                'link' => 'pengaduan-saya/show/' . $complaint->id
            ]);

            DB::commit();
            
            return redirect()->route('data-pengaduan.index')
                ->with('success', 'Pengaduan berhasil diverifikasi');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }

    public function show($id)
    {
        $complaint = Complaint::with(['user'])->findOrFail($id);
        $histories = json_decode($complaint->histories ?? '[]', true);
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'complaint' => $complaint,
                'histories' => $histories
            ]
        ]);
    }
}

