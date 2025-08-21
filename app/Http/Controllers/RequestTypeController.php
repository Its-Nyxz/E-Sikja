<?php

namespace App\Http\Controllers;

use App\Models\RequestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequestTypeController extends Controller
{
    public function __construct()
    {
        if (Auth::user()->role != 'admin') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestTypes = RequestType::all();
        return view('cms.request-type.index', [
            'title' => 'Jenis Permohonan',
            'requestTypes' => $requestTypes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cms.request-type.create', [
            'title' => 'Tambah Jenis Permohonan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:request_types,code',
            'name' => 'required',
            'description' => 'nullable',
            // 'additional_fields' => 'nullable|array',
            'required_documents' => 'nullable|array',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            $data = $request->all();

            // $data['additional_fields'] = $request->additional_fields ?  json_encode($request->additional_fields) : NULL;
            $data['required_documents'] = json_encode($request->required_documents);
            // dd($data);
            $requestType = RequestType::create($data);

            DB::commit();

            return redirect()->route('jenis-permohonan.index')
                ->with('success', 'Jenis permohonan berhasil ditambahkan');
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
    public function show($id)
    {
        $requestType = RequestType::findOrFail($id);
        return view('cms.request-type.show', [
            'title' => 'Detail Jenis Permohonan',
            'requestType' => $requestType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('cms.request-type.edit', [
            'title' => 'Edit Jenis Permohonan',
            'requestType' => RequestType::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:request_types,code,' . $id,
            'name' => 'required',
            'description' => 'nullable',
            // 'additional_fields' => 'nullable|array',
            'required_documents' => 'nullable|array',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $requestType = RequestType::findOrFail($id);
            $data = $request->all();

            // $data['additional_fields'] = $request->additional_fields ?  json_encode($request->additional_fields) : NULL;
            $data['required_documents'] = json_encode($request->required_documents);
            $requestType->update($data);

            DB::commit();

            return redirect()->route('jenis-permohonan.index')
                ->with('success', 'Jenis permohonan berhasil diperbarui');
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
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $requestType->delete();

            DB::commit();

            return redirect()->route('jenis-permohonan.index')
                ->with('success', 'Jenis permohonan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
