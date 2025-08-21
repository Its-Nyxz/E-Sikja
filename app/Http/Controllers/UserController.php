<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    public function __construct()
    {
        if (Auth::user()->role != 'admin' && (request()->routeIs('profile.index') === false && request()->routeIs('profile.update') === false)) {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
             $query = User::query();
            return DataTables::of($query)
                ->editColumn('created_at', function($row){
                    return (new \DateTime($row->created_at))->format('d-m-Y H:i');
                })
                
                ->addColumn('aksi', function($row){
                    $verifikasi = '';
                    if($row->status == 'Menunggu Verifikasi') {
                        $verifikasi = '<a href="'.route('verifikasi-pendaftaran.index', $row->id).'" class="btn btn-sm btn-info"><span class="fa fa-eye"></span></a>';
                    }
                    return '<div class="btn-group" role="group">
                            '.$verifikasi.'
                            <a href="'.route('manajemen-pengguna.edit', $row->id).'" class="btn btn-sm btn-warning"><span class="fa fa-edit"></span></a>
                            <form action="'.route('manajemen-pengguna.destroy', $row->id).'" method="post" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\');">
                                <button type="submit" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></button>
                                '.method_field('DELETE').csrf_field().'
                            </form>
                            
                        </div>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }else{

            $data = [
                'title' => 'Data Pengguna',  
            ];
    
            return view('cms.user.index')->with($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Data Pengguna',
        ];

        return view('cms.user.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,operator,masyarakat',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            \DB::beginTransaction();
            
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            
            User::create($data);
            
            \DB::commit();
            return redirect()
                ->route('manajemen-pengguna.index')
                ->with('success', 'Data Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error creating user: ' . $e->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'title' => 'Edit Data Pengguna',
            'user' => User::findOrFail($id)
        ];
        return view('cms.user.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,operator,masyarakat',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            \DB::beginTransaction();
            
            $user = User::findOrFail($id);
            
            $data = $request->all();
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            
            $user->update($data);
            
            \DB::commit();
            return redirect()
                ->route('manajemen-pengguna.index')
                ->with('success', 'Data Pengguna berhasil diperbarui');
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error updating user: ' . $e->getMessage());
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
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()
                ->route('manajemen-pengguna.index')
                ->with('success', 'Data Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    function verification($id)
    {
        $user = User::findOrFail($id);
        if ($user->status == 'Aktif') {
            return redirect()
                ->route('manajemen-pengguna.index')
                ->with('error', 'Data Pengguna sudah aktif');
        }
        $data = [
            'title' => 'Verifikasi Pendaftaran',
            'user' => User::findOrFail($id)
        ];
        return view('cms.user.verification')->with($data);
    }

    function verify($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Aktif';
        $user->save();


        DB::beginTransaction();
        try {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pendaftaran Berhasil',
                'text' => 'Selamat, akun Anda berhasil diverifikasi'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()
            ->route('manajemen-pengguna.index')
            ->with('success', 'Data Pengguna berhasil diverifikasi');
    }

    public function profile(Request $request)
    {
        if ($request->isMethod('put')) {
            $user = Auth::user();
            
            // Validate user data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                \DB::beginTransaction();
                
                // Update user data
                $data = $request->all();
                if (!empty($data['password'])) {
                    $data['password'] = Hash::make($data['password']);
                } else {
                    unset($data['password']);
                }
                
                $user->update($data);

                // If user is masyarakat and has resident data, update resident data
                if ($user->role === 'masyarakat' && $user->resident) {
                    $residentValidator = Validator::make($request->all(), [
                        'kk' => 'required|string|max:20',
                        'nik' => 'required|string|max:16|unique:residents,nik,' . $user->resident->id,
                        'pob' => 'required|string|max:100',
                        'dob' => 'required|date',
                        'gender' => 'required|in:Laki-laki,Perempuan',
                        'address' => 'required|string',
                        'rt' => 'required|string|max:5',
                        'rw' => 'required|string|max:5',
                        'sub_village' => 'nullable|string|max:100',
                        'village' => 'required|string|max:100',
                        'district' => 'required|string|max:100',
                        'religion' => 'required|string|max:20',
                        'marital_status' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
                        'occupation' => 'required|string|max:100',
                        'nationality' => 'nullable|string|max:50',
                        'education' => 'required|string|max:50',
                        'father_name' => 'nullable|string|max:100',
                        'mother_name' => 'nullable|string|max:100',
                    ]);

                    if ($residentValidator->fails()) {
                        \DB::rollBack();
                        return redirect()
                            ->back()
                            ->withErrors($residentValidator)
                            ->withInput();
                    }

                    $user->resident->update($request->all());
                }
                
                \DB::commit();
                return redirect()
                    ->back()
                    ->with('success', 'Profil berhasil diperbarui');
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::error('Error updating profile: ' . $e->getMessage());
                return redirect()
                    ->back()
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                    ->withInput();
            }
        } else {
            $data = [
                'title' => 'Profil Pengguna',
                'user' => Auth::user()
            ];
            return view('cms.user.profile')->with($data);
        }
    }
}
