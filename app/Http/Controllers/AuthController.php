<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('username', 'password');
        
        // Try to authenticate with email
        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
            if (Auth::user()->status == 'Aktif') {
                return redirect()->intended('/dashboard')->with('success', 'Berhasil login');
            }elseif (Auth::user()->status == 'Tidak Aktif') {
                Auth::logout();
                return redirect()->back()->with('error', 'Akun anda tidak aktif');
            }else{
                Auth::logout();
                return redirect()->back()->with('error', 'Akun anda sedang dalam verifikasi admin'); 
            }
        }

        // Try to authenticate with username
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            if (Auth::user()->status == 'Aktif') {
                return redirect()->intended('/dashboard')->with('success', 'Berhasil login');
            }elseif (Auth::user()->status == 'Tidak Aktif') {
                Auth::logout();
                return redirect()->back()->with('error', 'Akun anda tidak aktif');
            }else{
                Auth::logout();
                return redirect()->back()->with('error', 'Akun anda sedang dalam verifikasi admin'); 
            }
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function doregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6|confirmed',
            'kk' => 'required|max:16',
            'nik' => 'required|unique:residents,nik|max:16',
            'name' => 'required',
            'pob' => 'required',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
            'address' => 'required',
            'sub_village' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'village' => 'required',
            'district' => 'required',
            'religion' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'marital_status' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'occupation' => 'required',
            'education' => 'required|in:Tidak/Belum Sekolah,Tidak Tamat SD/Sederajat,Tamat SD/Sederajat,SLTP/Sederajat,SLTA/Sederajat,Diploma I/II,Akademi/Diploma III/S.Muda,Diploma IV/Strata I,Strata II,Strata III',
            'nationality' => 'required|in:WNI,WNA',
            'father_name' => 'required',
            'mother_name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create resident record
            $resident = Resident::create([
                'kk' => $request->kk,
                'nik' => $request->nik,
                'name' => $request->name,
                'pob' => $request->pob,
                'dob' => $request->dob,
                'gender' => $request->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                'address' => $request->address,
                'sub_village' => $request->sub_village,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'village' => $request->village,
                'district' => $request->district,
                'religion' => $request->religion,
                'marital_status' => $request->marital_status,
                'occupation' => $request->occupation,
                'education' => $request->education,
                'nationality' => $request->nationality,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
            ]);

            // Create user record
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'resident_id' => $resident->id
            ]);

            $admin = User::where('role', 'admin')->get();
            foreach ($admin as $ad) {
                Notification::create([
                    'user_id' => $ad['id'],
                    'title' => 'Pendaftaran Baru',
                    'text' => 'Pendaftaran baru telah dibuat oleh ' . $user->name,
                    'type' => 'Pendaftaran',
                    'read' => false,
                    'link' => 'verifikasi-pendaftaran/' . $user->id
                ]);
            }


            DB::commit();

            return redirect('/login')->with('success', 'Pendaftaran berhasil, sedang dalam verifikasi administrator.');
        } catch (\Exception $e) {
            DB::rollBack();
        // dd($e);

            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'])
                ->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Berhasil logout');
    }
}


