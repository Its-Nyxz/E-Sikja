<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    protected $settingsPath;

    public function __construct()
    {
        if(Auth::user()->role != 'admin') {
            return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses')->send();
        }
        $this->settingsPath = public_path('setting/settings.json');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Pengaturan',
            'settings' => $this->getSettings()
        ];
        return view('cms.setting.index')->with($data);
    }

    public function save(Request $request)
    {
        $settings = $this->getSettings();
        
        // Handle file uploads
        $fileFields = ['logo', 'favicon', 'ttd_lurah', 'cap_lurah'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                
                // Delete old file if exists
                if (isset($settings[$field]) && File::exists(public_path('setting/' . $settings[$field]))) {
                    File::delete(public_path('setting/' . $settings[$field]));
                }
                
                // Move new file
                $file->move(public_path('setting'), $filename);
                $settings[$field] = $filename;
            }
        }

        // Handle text fields
        $textFields = [
            'website_name',
            'website_description',
            'email',
            'nama_lurah',
            'nip_lurah',
            'alamat',
            'telepon',
            'whatsapp',
            'facebook',
            'instagram',
            'twitter',
            'youtube'
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                $settings[$field] = $request->input($field);
            }
        }

        // Save settings
        $this->saveSettings($settings);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan'
        ]);
    }

    public function profile()
    {
        $settings = $this->getSettings();
        $data = [
            'title' => 'Profil Instansi',
            'settings' => $settings
        ];
        return view('cms.setting.profile')->with($data);
    }

    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'visi_misi' => 'required|string',
            'tentang_kelurahan' => 'required|string',
            'struktur_organisasi' => 'required|string',
        ]);

        $settings = $this->getSettings();
        // dd($settings, $validated);
        $settings['profile'] = $validated;

        $this->saveSettings($settings);

        return redirect()->back()->with('success', 'Profil instansi berhasil diperbarui');
    }

    protected function getSettings()
    {
        if (!File::exists($this->settingsPath)) {
            return [];
        }

        $content = File::get($this->settingsPath);
        return json_decode($content, true) ?? [];
    }

    protected function saveSettings($settings)
    {
        $directory = dirname($this->settingsPath);
        
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        File::put($this->settingsPath, json_encode($settings, JSON_PRETTY_PRINT));
    }
}

