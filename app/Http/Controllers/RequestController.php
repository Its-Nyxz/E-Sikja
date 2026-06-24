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
use App\Exports\RequestExport;
use Maatwebsite\Excel\Facades\Excel;

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
                ->when($request->status && $request->status != 'semua', function ($q) use ($request) {
                    // Capitalize status from JS tab ID to match DB enum (e.g. 'diajukan' -> 'Diajukan')
                    return $q->where('status', ucfirst($request->status));
                })
                ->when($request->date_from, function ($q) use ($request) {
                    return $q->whereDate('created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($q) use ($request) {
                    return $q->whereDate('created_at', '<=', $request->date_to);
                })
                ->when($request->request_type_id, function ($q) use ($request) {
                    return $q->where('request_type_id', $request->request_type_id);
                });
            // if (Auth::user()->role == 'admin') {
            //     $query = $query->whereIn('status', ['Diproses', 'Ditolak', 'Selesai']);
            // }else{
            //     // $query = $query->where('status', '!=' ,'Diajukan');
            // }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('d-m-Y', strtotime($row->created_at));
                })
                ->addColumn('request_type', function ($row) {
                    return $row->requestType->name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';

                    if (($row->status == 'Diajukan' && Auth::user()->role == 'operator') || ($row->status == 'Diproses' && Auth::user()->role == 'admin')) {
                        $actionBtn = '<a href="' . route('data-pengajuan.verifikasi-' . Auth::user()->role, $row->id) . '" class="btn btn-sm btn-primary">
                            <i class="fas fa-check"></i> Verifikasi
                        </a>';
                    } elseif ($row->status == 'Selesai' && Auth::user()->role == 'admin') {
                        $actionBtn = '<a target="_blank" href="' . route('data-pengajuan.print', $row->id) . '" class="btn btn-sm btn-success">
                            <i class="fas fa-print"></i> Print
                        </a>';
                    } else {
                        $actionBtn = '<a href="' . route('data-pengajuan.show', $row->id) . '" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $data = [
            'title'        => 'Data Pengajuan',
            'requestTypes' => \App\Models\RequestType::where('status', true)->orderBy('name')->get(),
        ];

        return view('cms.request.index', $data);
    }

    public function exportExcel(Request $request)
    {
        try {
            $filters = $request->only(['status', 'date_from', 'date_to', 'request_type_id']);
            $role = Auth::user()->role;

            return Excel::download(new RequestExport($filters, $role), 'Data_Pengajuan_' . date('YmdHis') . '.xlsx');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Export gagal: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $requestLetter = RequestLetter::with([
            'requestType',
            'user.resident',
            'documentRequestLetters',
            'historyRequestLetters'
        ])->findOrFail($id);

        // if (!$requestLetter->user) {
        //     return redirect()
        //         ->route('data-pengajuan.index')
        //         ->with('error', 'Data user/pemohon tidak ditemukan.');
        // }

        // if (!$requestLetter->user->resident) {
        //     return redirect()
        //         ->route('data-pengajuan.index')
        //         ->with('error', 'Data kependudukan pemohon belum lengkap.');
        // }

        return view('cms.request.show', [
            'title' => 'Detail Pengajuan',
            'requestLetter' => $requestLetter
        ]);
    }

    public function verifikasiOperator($id)
    {
        if (Auth::user()->role != 'operator') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $requestLetter = RequestLetter::find($id);
        $data = [
            'title' => 'Verifikasi Operator',
            'requestLetter' => $requestLetter
        ];

        return view('cms.request.verifikasi-operator', $data);
    }

    public function verifikasiAdmin($id)
    {
        if (Auth::user()->role != 'admin') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $requestLetter = RequestLetter::find($id);
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
                $notes = "Pengajuan ditolak oleh petugas (" . Auth::user()->name . ")." . ($request->notes ? " Catatan: " . $request->notes : "");
            } else if ($status == 'Selesai') {
                if ($requestLetter->document_number) {
                    $data['document_number'] = $requestLetter->document_number;
                } else {
                    $typeCode = $requestLetter->requestType->code;

                    $prefix = $typeCode . '/' . date('y') . '/' . date('m') . '/' . date('d');

                    $getLast = RequestLetter::where('request_type_id', $requestLetter->request_type_id)
                        ->where('id', '!=', $requestLetter->id)
                        ->whereNotNull('document_number')
                        ->where('document_number', 'like', $prefix . '/%')
                        ->orderBy('document_number', 'desc')
                        ->lockForUpdate()
                        ->first();

                    $lastNumber = $getLast
                        ? intval(substr($getLast->document_number, -3)) + 1
                        : 1;

                    $documentNumber = $prefix . '/' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

                    while (RequestLetter::where('document_number', $documentNumber)->exists()) {
                        $lastNumber++;
                        $documentNumber = $prefix . '/' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
                    }

                    $data['document_number'] = $documentNumber;
                }

                $notes = "Pengajuan telah selesai diverifikasi oleh petugas (" . Auth::user()->name . ") dan dokumen sudah dapat dicetak." . ($request->notes ? " Catatan: " . $request->notes : "");
            } else if ($status == 'Diproses') {
                $notes = "Pengajuan telah diverifikasi oleh petugas (" . Auth::user()->name . ") dan sedang diteruskan ke Admin untuk diproses." . ($request->notes ? " Catatan: " . $request->notes : "");
            } else {
                $notes = "Status pengajuan diperbarui menjadi " . $status . " oleh petugas (" . Auth::user()->name . ")." . ($request->notes ? " Catatan: " . $request->notes : "");
            }
            $requestLetter->update($data);

            HistoryRequestLetter::create([
                'request_letter_id' => $requestLetter->id,
                'status' => $request->status,
                'notes' =>  $notes
            ]);

            if ($status == 'Diproses') {
                $admins = User::where('role', 'admin')->get();

                foreach ($admins as $admin) {
                    // Send notification to admin
                    Notification::create([
                        'type' => 'Pengajuan',
                        'user_id' => $admin->id,
                        'title' => 'Update Status Pengajuan ' . $requestLetter->requestType->name,
                        'text' => 'Pengajuan dengan nomor ' . $requestLetter->code . ' telah ' . strtolower($request->status) . ' oleh operator',
                        'link' => '/data-pengajuan/verifikasi-admin/' . $requestLetter->id
                    ]);
                }
            } else {
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
        $requestLetter = RequestLetter::with([
            'requestType',
            'user.resident',
            'historyRequestLetters'
        ])->findOrFail($id);

        if ($requestLetter->status != 'Selesai') {
            return redirect()->back()->with('error', 'Pengajuan belum selesai');
        }

        if (!$requestLetter->user) {
            return redirect()->back()->with('error', 'Data user/pemohon tidak ditemukan. Dokumen tidak dapat dicetak.');
        }

        if (!$requestLetter->user->resident) {
            return redirect()->back()->with('error', 'Data kependudukan pemohon belum lengkap. Dokumen tidak dapat dicetak.');
        }

        if (!$requestLetter->requestType) {
            return redirect()->back()->with('error', 'Jenis pengajuan tidak ditemukan. Dokumen tidak dapat dicetak.');
        }

        $data = [
            'title' => 'Print Pengajuan',
            'requestLetter' => $requestLetter,
            'requestType' => $requestLetter->requestType,
            'resident' => $requestLetter->user->resident,
            'lastHistory' => $requestLetter->historyRequestLetters->last(),
            'data' => json_decode($requestLetter->data)
        ];

        $pdf = PDF::loadView('cms.my-request.print.' . strtolower($data['requestType']->code), $data)
            ->setPaper('a4');

        $filename = 'pengajuan-' . str_replace(['/', '\\'], '-', $requestLetter->code) . '.pdf';

        return $pdf->stream($filename);
    }
}
