<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Resident;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $username = $request->old('username', 'guest');
        $lockoutKey = 'login_attempts_' . $username . '_' . $request->ip() . '_time';
        $lockoutTime = Cache::get($lockoutKey);
        $isLocked = false;
        $remainingSeconds = 0;

        if ($lockoutTime && Carbon::now()->lessThan($lockoutTime)) {
            $isLocked = true;
            // Pastikan angka positif dan bulat (dibulatkan ke bawah)
            $remainingSeconds = max(0, (int) floor(Carbon::now()->diffInSeconds($lockoutTime, false)));
        } else {
            Cache::forget($lockoutKey);
        }

        return view('auth.login', compact('isLocked', 'remainingSeconds'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $username = $request->input('username');
        $password = $request->input('password');

        $key = 'login_attempts_' . $username . '_' . $request->ip();
        $lockoutKey = $key . '_time';

        $attempts = Cache::get($key, 0);
        $lockoutTime = Cache::get($lockoutKey);

        // 🧹 STEP 1: Reset jika masa tunggu sudah habis
        if ($lockoutTime && Carbon::now()->greaterThanOrEqualTo($lockoutTime)) {
            Cache::forget($key);
            Cache::forget($lockoutKey);
            $attempts = 0;
            $lockoutTime = null;
        }

        // 🚫 STEP 2: Jika masih terkunci
        if ($lockoutTime && Carbon::now()->lessThan($lockoutTime)) {
            $remaining = max(0, (int) ceil(Carbon::now()->diffInRealSeconds($lockoutTime, false)));
            return redirect()->back()->with('error', "Terlalu banyak percobaan gagal. Silakan coba lagi dalam {$remaining} detik.");
        }

        // 🔐 STEP 3: Coba login (email atau username)
        if (
            Auth::attempt(['email' => $username, 'password' => $password]) ||
            Auth::attempt(['username' => $username, 'password' => $password])
        ) {
            if (Auth::user()->status == 'Aktif') {
                Cache::forget($key);
                Cache::forget($lockoutKey);
                return redirect()->intended('/dashboard')->with('success', 'Berhasil login');
            } elseif (Auth::user()->status == 'Tidak Aktif') {
                Auth::logout();
                return redirect()->back()->with('error', 'Akun anda tidak aktif');
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Akun anda sedang dalam verifikasi admin');
            }
        }

        // 🚨 STEP 4: Tambah percobaan gagal terlebih dahulu
        $attempts++;

        // STEP 5: Jika sudah gagal ke-3 kali, langsung kunci
        if ($attempts >= 3) {
            $lockoutTime = Carbon::now()->addSeconds(15);
            Cache::put($lockoutKey, $lockoutTime, $lockoutTime);
            Cache::put($key, $attempts, $lockoutTime);
            $remaining = (int) ceil(Carbon::now()->diffInRealSeconds($lockoutTime, false));

            return redirect()->back()->with('error', "Terlalu banyak percobaan gagal. Silakan coba lagi dalam {$remaining} detik.");
        }

        // STEP 6: Kalau belum 3x, baru simpan percobaannya dan tampilkan pesan salah
        Cache::put($key, $attempts, now()->addSeconds(15));

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function register()
    {
        return view('auth.register');
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

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan dalam sistem.');
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        // Simpan OTP ke cache (berlaku 5 menit)
        Cache::put('otp_' . $user->email, [
            'code' => $otp,
            'expires_at' => $expiresAt
        ], $expiresAt);

        // Kirim Email
        Mail::send('emails.otp', ['otp' => $otp, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Kode OTP Reset Password');
        });

        return redirect()->route('auth.reset-password')->with([
            'success' => 'Kode OTP telah dikirim ke email Anda. Silakan periksa kotak masuk.',
            'email' => $user->email
        ]);
    }

    public function resetPasswordForm(Request $request)
    {
        $email = session('email');
        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sama dengan password baru.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $data = Cache::get('otp_' . $request->email);

        if (!$data || $data['code'] != $request->otp) {
            return redirect()->back()->withInput()->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa.');
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan.');
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Hapus OTP dari cache
        Cache::forget('otp_' . $request->email);

        // ✅ Setelah berhasil reset password, tampilkan alert sukses di halaman login
        return redirect()->route('login')->with('success', 'Password berhasil diperbarui! Silakan login menggunakan password baru Anda.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
