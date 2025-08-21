<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RequestType;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\RequestLetter;
use Illuminate\Support\Facades\DB;
use App\Models\HistoryRequestLetter;
use App\Models\DocumentRequestLetter;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


class MyRequestController extends Controller
{
    protected string $pathUpload, $pathPublic;

    public function __construct()
    {
        if (Auth::user()->role != 'masyarakat') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }

        $this->pathUpload = 'uploads/documents/';
        // $this->pathPublic = public_path($this->pathUpload);
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
            $status = $request->status;
            
            $query = RequestLetter::where('user_id', auth()->id());
            if ($status != 'semua') {
                $query =$query->where('status', $status);
            }
            $query =$query->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('request_type', function($row) {
                    return $row->requestType->name;
                })
                ->addColumn('created_at', function($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->addColumn('action', function($row) {
                    $actionBtn = '<div class="btn-group" role="group" aria-label="Basic example">';
                    $actionBtn .= '<a href="'.route('pengajuan-saya.show', $row->id).'" class="btn btn-info btn-sm"><span class="fa fa-eye"></span></a>';
                    if ($row->status == 'Diajukan') {
                        $actionBtn .= '<a href="'.route('pengajuan-saya.edit', $row->id).'" class="btn btn-warning btn-sm"><span class="fa fa-edit"></span></a>';
                        $actionBtn .= '<form action="'.route('pengajuan-saya.destroy', $row->id).'" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus permohonan ini?\');">
                                        '.csrf_field().method_field('DELETE').'
                                        <button type="submit" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                       </form>';
                    }else if ($row->status == 'Selesai') {
                        $actionBtn .= '<a href="'.route('pengajuan-saya.print', $row->id).'" class="btn btn-success btn-sm"><span class="fa fa-print"></span></a>';
                    }
                    $actionBtn .= '</div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cms.my-request.index', [
            'title' => 'Pengajuan Saya'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Buat Pengajuan Baru',
            'requestTypes' => RequestType::where('status', true)->get()
        ];

        return view('cms.my-request.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $requestType = RequestType::find($request->request_type_id);
            unset($data['documents']);
            unset($data['_token']);
            // dd($data);
           

            $code = "REQ/$requestType->code/".date('y')."/".date('m')."/".date('d');
            $requestLetterLast = RequestLetter::where('code', 'like', "$code%")->latest()->first();
            $lastNumber = $requestLetterLast ? intval(substr($requestLetterLast->code, -3)) + 1 : 1;
            $code .= '/'.str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
            
            // Create request letter
            $requestLetter = RequestLetter::create([
                'request_type_id' => $requestType->id, 
                'user_id' => auth()->user()->id,
                'code' => $code,
                'data' => json_encode($data)
            ]);

            // Handle document uploads
            if ($request->hasFile('documents')) {
                $documents = $request->file('documents');
                $requiredDocuments = json_decode($requestType->required_documents);
                $this->pathUpload = "$this->pathUpload/$requestType->code/";
                $this->pathPublic = public_path($this->pathUpload) ?? $this->pathUpload;
                foreach ($documents as $index => $document) {
                    if ($document->isValid()) {
                        $documentName = Str::random(32) . '.' . $document->getClientOriginalExtension();
                        $document->move($this->pathPublic, $documentName);
                        
                        DocumentRequestLetter::create([
                            'request_letter_id' => $requestLetter->id,
                            'name' => $requiredDocuments[$index] ?? 'Document ' . ($index + 1),
                            'url' => $this->pathUpload . $documentName,
                            'type' => $document->getClientOriginalExtension(),
                            'description' => "Dokumen $requiredDocuments[$index] untuk permohonan $requestType->name"
                        ]);
                    }

                }
            }

            HistoryRequestLetter::create([
                'request_letter_id' => $requestLetter->id,
                'status' => 'Diajukan',
            ]);

            // Send notification
            $operator = User::where('role', 'operator')->get();
            foreach ($operator as $user) {
                Notification::create([ 
                    'type' => 'Pengajuan',
                    'user_id' => $user->id,
                    'title' => 'Pengajuan Baru '.$requestLetter->requestType->name,
                    'text' => 'Pengajuan baru telah dibuat oleh ' . auth()->user()->name. ' dengan nomor pengajuan ' . $requestLetter->code,
                    'link' => '/data-pengajuan/verifikasi-operator/' . $requestLetter->id
                ]);
            }

            DB::commit();

            return redirect()->route('pengajuan-saya.index')
                ->with('success', 'Pengajuan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'title' => 'Detail Pengajuan',
            'requestLetter' => Auth::user()->requestLetters()->findOrFail($id),
            'requestTypes' => RequestType::where('status', true)->get()
        ];

        return view('cms.my-request.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $requestLetter = Auth::user()->requestLetters()->findOrFail($id);
        if ($requestLetter->status != 'Diajukan') {
            return redirect()->back()->with('error', 'Pengajuan tidak dapat diedit karena sudah diverifikasi');
        }
        $data = [
            'title' => 'Edit Pengajuan',
            'requestLetter' =>  $requestLetter,
            'requestTypes' => RequestType::where('status', true)->get()
        ];

        return view('cms.my-request.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $requestLetter = RequestLetter::findOrFail($id);
            $requestType = RequestType::find($request->request_type_id);
            
            unset($data['documents']);
            unset($data['_token']);
            unset($data['_method']);

            // Update request letter
            $requestLetter->update([
                'request_type_id' => $requestType->id,
                'data' => json_encode($data)
            ]);

            // Handle document uploads
            if ($request->hasFile('documents')) {
                $documents = $request->file('documents');
                $requiredDocuments = json_decode($requestType->required_documents);
                $this->pathUpload = "$this->pathUpload/$requestType->code/";
                $this->pathPublic = public_path($this->pathUpload) ?? $this->pathUpload;
                
                foreach ($documents as $index => $document) {
                    if ($document->isValid()) {
                        $documentName = Str::random(32) . '.' . $document->getClientOriginalExtension();
                        $document->move($this->pathPublic, $documentName);
                        
                        // Delete old document if exists
                        $oldDocument = $requestLetter->documentRequestLetters->where('name', $requiredDocuments[$index] ?? 'Document ' . ($index + 1))->first();
                        if ($oldDocument) {
                            if (file_exists(asset($oldDocument->url))) {
                                unlink(asset($oldDocument->url));
                            }
                            $oldDocument->update(['url' => $this->pathUpload . $documentName]);
                        }else{
                            DocumentRequestLetter::create([
                                'request_letter_id' => $requestLetter->id,
                                'name' => $requiredDocuments[$index] ?? 'Document ' . ($index + 1),
                                'url' => $this->pathUpload . $documentName,
                                'type' => $document->getClientOriginalExtension(),
                                'description' => "Dokumen $requiredDocuments[$index] untuk permohonan $requestType->name"
                            ]);
                        }
                    }
                }
            }
                

            // Send notification
            $operator = User::where('role', 'operator')->get();
            foreach ($operator as $user) {
                Notification::create([ 
                    'type' => 'Pengajuan',
                    'user_id' => $user->id,
                    'title' => 'Pengajuan Diperbarui '.$requestLetter->requestType->name,
                    'text' => 'Pengajuan telah diperbarui oleh ' . auth()->user()->name. ' dengan nomor pengajuan ' . $requestLetter->code,
                    'link' => '/data-pengajuan/verifikasi-operator/' . $requestLetter->id
                ]);
            }

            DB::commit();

            return redirect()->route('pengajuan-saya.index')
                ->with('success', 'Pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $requestLetter = RequestLetter::findOrFail($id);
            $requestLetter->delete();
            return redirect()->route('pengajuan-saya.index')
                ->with('success', 'Pengajuan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function form(Request $request, $code)
    {
        // dd($request->all());
        $id = $request->id ?? null;

        $request->session()->flashInput($request->all());
        $requestType = RequestType::where('code', $code)->firstOrFail();
        
        $resident = auth()->user()->resident;


        $data = [
            'title' => 'Buat Pengajuan Baru',
            'requestType' => $requestType,
            'resident' => $resident,
            'old' => $request->all(),
        ];
        if ($id) {
            $requestLetter = RequestLetter::findOrFail($id);
            $data['requestLetter'] = json_decode($requestLetter->data);
            $data['requestLetter']->code = $requestLetter->code;
            // dd($data['requestLetter']);
            $data['documents'] = $requestLetter->documentRequestLetters;
            
            // dd($data['requestLetter']);
        }

        unset($data['old']->id);

        // dd($requestLetter);
        // dd($data['requestLetter']);
        return view('cms.my-request.form.'.strtolower($code))->with($data);
    }

    /**
     * Print the request letter as PDF
     */
    public function print($id)
    {
        $requestLetter = Auth::user()->requestLetters()->findOrFail($id);
        if ($requestLetter->status != 'Selesai') {
            return redirect()->back()->with('error', "Pengajuan belum selesai");
        }
        $data = [
            'title' => 'Print Pengajuan',
            'requestLetter' => $requestLetter,
            'requestType' => $requestLetter->requestType,
            'resident' => $requestLetter->user->resident,
            'lastHistory' => $requestLetter->historyRequestLetters->last(),
            'data' => json_decode($requestLetter->data)
        ];

        $pdf = PDF::loadView('cms.my-request.print.'.strtolower($data['requestType']->code), $data)
            ->setPaper('a4');
        $filename = 'pengajuan-' . str_replace(['/', '\\'], '-', $requestLetter->code) . '.pdf';
        return $pdf->stream($filename);
    }

    /**
     * Check the status of a pengajuan by its nomor_pengajuan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkStatus(Request $request)
    {
        try {
            $nomor_pengajuan = $request->query('nomor_pengajuan');
            
            if (!$nomor_pengajuan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor pengajuan tidak ditemukan'
                ]);
            }

            $pengajuan = RequestLetter::where('code', $nomor_pengajuan)
                ->where('user_id', auth()->id())
                ->first();

            if (!$pengajuan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor pengajuan tidak ditemukan'
                ]);
            }

            $status = $pengajuan->historyRequestLetters->last()->status;
            $message = '';
            $details = '';

            switch ($status) {
                case 'Diajukan':
                    $message = 'Pengajuan Anda sedang menunggu verifikasi';
                    $details = 'Mohon tunggu, pengajuan Anda akan segera diproses';
                    break;
                case 'Diproses':
                    $message = 'Pengajuan Anda sedang diproses';
                    $details = 'Tim kami sedang memproses pengajuan Anda';
                    break;
                case 'Selesai':
                    $message = 'Pengajuan Anda telah selesai';
                    $details = 'Pengajuan Anda telah selesai diproses';
                    break;
                case 'Ditolak':
                    $message = 'Pengajuan Anda ditolak';
                    $details = $pengajuan->historyRequestLetters->last()->notes ?? 'Pengajuan tidak memenuhi persyaratan';
                    break;
                default:
                    $message = 'Status pengajuan tidak diketahui';
            }

            // Get history data
            $history = $pengajuan->historyRequestLetters()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'status' => $item->status,
                        'notes' => $item->notes,
                        'created_at' => $item->created_at->format('d/m/Y H:i')
                    ];
                });

            return response()->json([
                'success' => true,
                'status' => strtolower($status),
                'message' => $message,
                'details' => $details,
                'history' => $history,
                'pengajuan' => [
                    'code' => $pengajuan->code,
                    'id' => $pengajuan->id,
                    'type' => $pengajuan->requestType->name,
                    'created_at' => $pengajuan->created_at->format('d/m/Y H:i')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memeriksa status pengajuan'
            ], 500);
        }
    }
}
