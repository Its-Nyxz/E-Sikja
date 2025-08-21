<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('cms.user.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Validate user data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Update user data
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // If user is masyarakat and has resident data, update resident data
            if ($user->role === 'masyarakat' && $user->resident) {
                $residentValidator = Validator::make($request->all(), [
                    'nik' => 'required|string|max:16|unique:residents,nik,' . $user->resident->id,
                    'kk' => 'required|string|max:20',
                    'pob' => 'required|string|max:100',
                    'dob' => 'required|date',
                    'gender' => 'required|in:Laki-laki,Perempuan',
                    'address' => 'required|string',
                    'rt' => 'required|string|max:5',
                    'rw' => 'required|string|max:5',
                    'village' => 'required|string|max:100',
                    'district' => 'required|string|max:100',
                    'religion' => 'required|string|max:20',
                    'marital_status' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
                    'occupation' => 'required|string|max:100',
                    'education' => 'required|string|max:50',
                    'father_name' => 'nullable|string|max:100',
                    'mother_name' => 'nullable|string|max:100',
                ]);

                if ($residentValidator->fails()) {
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->withErrors($residentValidator)
                        ->withInput();
                }

                $user->resident->update($request->all());
            }

            DB::commit();
            return redirect()
                ->back()
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
} 