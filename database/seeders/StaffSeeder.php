<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffs = [
            ['nama_lengkap' => 'Budi Santoso',   'posisi' => 'chef',   'status_aktif' => true],
            ['nama_lengkap' => 'Siti Rahayu',     'posisi' => 'chef',   'status_aktif' => true],
            ['nama_lengkap' => 'Ahmad Fauzi',     'posisi' => 'chef',   'status_aktif' => true],
            ['nama_lengkap' => 'Agus Purnama',    'posisi' => 'supir',  'status_aktif' => true],
            ['nama_lengkap' => 'Doni Kusuma',     'posisi' => 'supir',  'status_aktif' => true],
            ['nama_lengkap' => 'Rizky Pratama',   'posisi' => 'supir',  'status_aktif' => true],
            ['nama_lengkap' => 'Dewi Anggraini',  'posisi' => 'manajer','status_aktif' => true],
            ['nama_lengkap' => 'Hendra Wijaya',   'posisi' => 'staf',   'status_aktif' => true],
            ['nama_lengkap' => 'Rina Melati',     'posisi' => 'staf',   'status_aktif' => true],
            ['nama_lengkap' => 'Wahyu Nugroho',   'posisi' => 'staf',   'status_aktif' => true],
        ];

        foreach ($staffs as $staff) {
            Staff::updateOrCreate(
                ['nama_lengkap' => $staff['nama_lengkap']],
                $staff
            );
        }
    }
}
