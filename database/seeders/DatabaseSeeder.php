<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Resident;
use App\Models\RequestType;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $residentId =Resident::create([
            'kk' => '33130768346737',
            'nik' => '3313987678964',
            'name' => 'Azka El',
            'pob' => 'Karanganyar',
            'dob' => '2001-11-14',
            'gender' => 'Laki-laki',
            'address' => 'Kerten',
            'rt' => '03',
            'rw' => '14',
            'sub_village' => '-',
            'village' => 'Jantiharjo',
            'district' => 'Karanganyar',
            'religion' => 'Islam',
            'marital_status' => 'Belum Kawin',
            'occupation' => 'Mahasiswa',
            'nationality' => 'WNI',
            'education' => 'S1',
            'father_name' => 'Suryanto',
            'mother_name' => 'Sugiyem',
        ]);

        User::create([
            'name' => 'Azka El',
            'username' => 'Azka',
            'email' => 'elazka98@gmail.com',
            'password' => bcrypt('azka123'),
            'role' => 'masyarakat',
            'resident_id' => $residentId->id,
            'status' => 'Aktif',
        ]);

        for ($i=1; $i <=2 ; $i++) { 
            User::create([
                'name' => "Operator $i",
                'username' => "operator$i",
                'email' => "operator$i@operator$i.com",
                'password' => bcrypt("operator$i"),
                'role' => 'operator',
                'status' => 'Aktif',
            ]);
        }

        User::create([
            'name' => "Administrator",
            'username' => "admin",
            'email' => "admin@admin.com",
            'password' => bcrypt("admin123"),
            'role' => 'admin',
            'status' => 'Aktif',
        ]);

        RequestType::insert([
            [
                'code' => 'SKKEL',
                'name' => 'Surat Keterangan Kelahiran',
                'description' => 'Permohonan surat keterangan kelahiran.',
                'required_documents' => '["KTP", "KK", "Surat Kelahiran dari Rumah Sakit"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SKKEM',
                'name' => 'Surat Keterangan Kematian',
                'description' => 'Permohonan surat keterangan kematian.',
                'required_documents' => '["KTP", "KK", "Surat Kematian dari Rumah Sakit"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SKPKW',
                'name' => 'Surat Keterangan Perkawinan',
                'description' => 'Permohonan surat keterangan perkawinan.',
                'required_documents' => '["KTP", "KK", "Buku Nikah"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SKPCR',
                'name' => 'Surat Keterangan Perceraian',
                'description' => 'Permohonan surat keterangan perceraian.',
                'required_documents' => '["KTP", "KK", "Akta Cerai"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SKDMS',
                'name' => 'Surat Keterangan Domisili',
                'description' => 'Permohonan surat keterangan domisili.',
                'required_documents' => '["KTP", "KK"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SKPDT',
                'name' => 'Surat Keterangan Pindah Datang',
                'description' => 'Permohonan surat keterangan pindah datang.',
                'required_documents' => '["KTP", "KK", "Surat Pindah dari Daerah Asal"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SKTM',
                'name' => 'Surat Keterangan Tidak Mampu',
                'description' => 'Permohonan surat keterangan tidak mampu.',
                'required_documents' => '["KTP", "KK", "Surat Pengantar RT/RW"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SKIU',
                'name' => 'Surat Keterangan Izin Usaha',
                'description' => 'Permohonan surat keterangan izin usaha.',
                'required_documents' => '["KTP", "KK", "Surat Pengantar RT/RW", "Bukti Usaha"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null,
            ],
            [
                'code' => 'SP-SKCK',
                'name' => 'Surat Pengantar Pembuatan SKCK',
                'description' => 'Permohonan surat pengantar pembuatan SKCK.',
                'required_documents' => '["KTP","KK","Surat Pengantar RT\\/RW (Optional)"]',
                'status' => 1,
                'created_at' => null,
                'updated_at' => '2025-05-24 07:15:10',
                'deleted_at' => null,
            ],
        ]);


    }
}
