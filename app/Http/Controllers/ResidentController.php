<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ResidentController extends Controller
{
    public function __construct()
    {
        if (Auth::user()->role == 'masyarakat' || ( Auth::user()->role == 'operator' && (request()->routeIs('data-masyarakat.index') === false && request()->routeIs('data-masyarakat.show') === false))) {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
             $query = Resident::query();
            return DataTables::of($query)
                ->addColumn('ttl', function($row){
                    return $row->pob . ', ' . (new \DateTime($row->dob))->format('d-m-Y');
                })
                ->addColumn('rt_rw', function($row){
                    return $row->rt . '/' . $row->rw;
                })
                ->addColumn('aksi', function($row){
                    $show = '<a href="'.route('data-masyarakat.show', $row->id).'" class="btn btn-sm btn-info"><span class="fa fa-eye"></span></a>';
                    $edit = '';
                    $delete = '';
                    if (Auth::user()->role == 'admin') {
                        $edit = '<a href="'.route('data-masyarakat.edit', $row->id).'" class="btn btn-sm btn-warning"><span class="fa fa-edit"></span></a>';
                        $delete = '<form action="'.route('data-masyarakat.destroy', $row->id).'" method="post" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\');">
                                    <button type="submit" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></button>
                                    '.method_field('DELETE').csrf_field().'
                                </form>';
                    }
                    return '<div class="btn-group" role="group">
                            '.$show.'
                            '.$edit.'
                            '.$delete.'
                        </div>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }else{

            $data = [
                'title' => 'Data Masyarakat',  
            ];
    
            return view('cms.resident.index')->with($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Data Masyarakat',
        ];

        return view('cms.resident.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kk' => 'required|string|max:20',
            'nik' => 'required|string|max:16|unique:residents,nik',
            'name' => 'required|string|max:100',
            'pob' => 'required|string|max:100',
            'dob' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'village' => 'required|string|max:100',
            'sub_village' => 'nullable|string|max:100',
            'district' => 'required|string|max:100',
            'religion' => 'required|string|max:20',
            'marital_status' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'occupation' => 'required|string|max:100',
            'nationality' => 'nullable|string|max:50',
            'education' => 'required|string|max:50',
            'father_name' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $resident = Resident::create($request->all());
            $user = User::create([
                'name' => $request->name,
                'resident_id' => $resident->id,
                'username' => $request->nik,
                'email' => $request->nik . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'masyarakat'
            ]);

            DB::commit();
            return redirect()
                ->route('data-masyarakat.index')
                ->with('success', 'Data masyarakat berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
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
            'title' => 'Detail Data Masyarakat',
            'resident' => Resident::findOrFail($id)
        ];
        return view('cms.resident.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Data Masyarakat',
            'resident' => Resident::findOrFail($id)
        ];
        return view('cms.resident.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'kk' => 'required|string|max:20',
            'nik' => 'required|string|max:16|unique:residents,nik,' . $id,
            'name' => 'required|string|max:100',
            'pob' => 'required|string|max:100',
            'dob' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'village' => 'required|string|max:100',
            'sub_village' => 'nullable|string|max:100',
            'district' => 'required|string|max:100',
            'religion' => 'required|string|max:20',
            'marital_status' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'occupation' => 'required|string|max:100',
            'nationality' => 'nullable|string|max:50',
            'education' => 'required|string|max:50',
            'father_name' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $resident = Resident::findOrFail($id);
            $resident->update($request->all());

            $user = User::withTrashed()->where('resident_id', $id)->first();
            if ($user) {
                $user->update(['name' => $request->name]);
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'resident_id' => $id,
                    'username' => $request->nik,
                    'email' => $request->nik . '@example.com',
                    'password' => Hash::make('password'),
                    'role' => 'masyarakat'
                ]);
            }

            DB::commit();
            return redirect()
                ->route('data-masyarakat.index')
                ->with('success', 'Data masyarakat berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $resident = Resident::findOrFail($id);
            $user = User::where('resident_id', $id)->first();
            
            if ($user) {
                $user->delete();
            }
            $resident->delete();
            
            DB::commit();
            return redirect()
                ->route('data-masyarakat.index')
                ->with('success', 'Data masyarakat berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
