<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\RequestLetter;
use Illuminate\Support\Facades\DB;
use App\Models\HistoryRequestLetter;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RequestController extends Controller
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
            $query = RequestLetter::with(['user', 'requestType'])
                ->when($request->status && $request->status != 'semua', function($q) use ($request) {
                    return $q->where('status', $request->status);
                });
            // if (Auth::user()->role == 'admin') {
            //     $query = $query->whereIn('status', ['Diproses', 'Ditolak', 'Selesai']);
            // }else{
            //     // $query = $query->where('status', '!=' ,'Diajukan');
            // }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->addColumn('request_type', function($row) {
                    return $row->requestType->name;
                })
                ->addColumn('action', function($row) {
                    $actionBtn = '';
                    
                    if (($row->status == 'Diajukan' && Auth::user()->role == 'operator') || ($row->status == 'Diproses' && Auth::user()->role == 'admin')) {
                        $actionBtn = '<a href="'.route('data-pengajuan.verifikasi-'.Auth::user()->role, $row->id).'" class="btn btn-sm btn-primary">
                            <i class="fas fa-check"></i> Verifikasi
                        </a>';
                    }elseif ($row->status == 'Selesai' && Auth::user()->role == 'admin') {
                        $actionBtn = '<a target="_blank" href="'.route('data-pengajuan.print', $row->id).'" class="btn btn-sm btn-success">
                            <i class="fas fa-print"></i> Print
                        </a>';
                    } else {
                        $actionBtn = '<a href="'.route('data-pengajuan.show', $row->id).'" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>';
                    }
                    
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $data = [
            'title' => 'Data Pengajuan'
        ];

        return view('cms.request.index', $data);
    }

    public function show($id){
        $data = [
          'title' => 'Detail Pengajuan',
          'requestLetter' => RequestLetter::find($id)
        ];

        return view('cms.request.show', $data);
    }

    public function verifikasiOperator($id){
        if (Auth::user()->role != 'operator') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $requestLetter = RequestLetter::find($id);
        if ($requestLetter->status != 'Diajukan') {
            return redirect('dashboard')->with('error', 'Pengajuan tidak dapat diverifikasi')->send();
        }
        $data = [
          'title' => 'Verifikasi Operator',
          'requestLetter' => $requestLetter
        ];

        return view('cms.request.verifikasi-operator', $data);
    }

    public function verifikasiAdmin($id){
        if (Auth::user()->role != 'admin') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $requestLetter = RequestLetter::find($id);
        if ($requestLetter->status != 'Diproses') {
            return redirect('dashboard')->with('error', 'Pengajuan tidak dapat diverifikasi')->send();
        }
        $data = [
          'title' => 'Verifikasi Admin',
          'requestLetter' => $requestLetter
        ];

        return view('cms.request.verifikasi-admin', $data);
    }

    public function updateVerifikasi(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $status = $request->status;

            $requestLetter = RequestLetter::findOrFail($id);
            
            // Update request letter status
            
            $data = [
                'status' => $status
            ];
            // Create history
            if ($status == 'Ditolak') {
                $notes = 'Pengajuan ditolak oleh '.Auth::user()->name.'.' . ($request->notes ? ' dengan catatan: ' . $request->notes : '');
            } else if ($status == 'Selesai') {
                $typeCode = $requestLetter->requestType->code;
                $documentNumber = "$typeCode/" . date('y') . "/" . date('m') . "/" . date('d');
                $getLast = RequestLetter::where('request_type_id', $requestLetter->request_type_id)->latest()->first();
                $lastNumber = $getLast ? intval(substr($getLast->document_number, -3)) + 1 : 1;
                $documentNumber .= '/' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
                $data['document_number'] = $documentNumber;
                $notes = 'Pengajuan selesai diverifikasi '.Auth::user()->name.'.' . ($request->notes ? ' dengan catatan: ' . $request->notes : '');
            } else {
                $notes = 'Pengajuan diteruskan ke admin.' . ($request->notes ? ' dengan catatan: ' . $request->notes : '');
            }
            $requestLetter->update($data);

            HistoryRequestLetter::create([
                'request_letter_id' => $requestLetter->id,
                'status' => $request->status,
                'notes' =>  $notes
            ]);

            if($status == 'Diproses'){
                $admins = User::where('role', 'admin')->get();
    
                foreach ($admins as $admin) {
                    // Send notification to admin
                    Notification::create([
                        'type' => 'Pengajuan',
                        'user_id' => $admin->id,
                        'title' => 'Update Status Pengajuan ' . $requestLetter->requestType->name,
                        'text' => 'Pengajuan dengan nomor ' . $requestLetter->code . ' telah ' . strtolower($request->status). ' oleh operator',
                        'link' => '/data-pengajuan/verifikasi-admin/' . $requestLetter->id
                    ]);
                }
            }else{
                Notification::create([
                    'type' => 'Pengajuan',
                    'user_id' => $requestLetter->user_id,
                    'title' => 'Update Status Pengajuan ' . $requestLetter->requestType->name,
                    'text' => 'Pengajuan Anda dengan nomor ' . $requestLetter->code . ' telah ' . strtolower($request->status),
                    'link' => '/pengajuan-saya/show/' . $requestLetter->id
                ]);
            }
            // dd($requestLetter);
            

            // Send notification to user
            // Notification::create([
            //     'type' => 'Pengajuan',
            //     'user_id' => $requestLetter->user_id,
            //     'title' => 'Update Status Pengajuan ' . $requestLetter->requestType->name,
            //     'text' => 'Pengajuan Anda dengan nomor ' . $requestLetter->code . ' telah ' . strtolower($request->status),
            //     'link' => '/pengajuan-saya/' . $requestLetter->id
            // ]);

            DB::commit();

            return redirect()->route('data-pengajuan.show', $requestLetter->id)->with('success', 'Status pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function print($id)
    {
        $requestLetter = RequestLetter::findOrFail($id);
        if ($requestLetter->status != 'Selesai') {
            return redirect()->back()->with('error', 'Pengajuan belum selesai');
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
}
