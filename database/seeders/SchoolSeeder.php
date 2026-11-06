<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'nama_sekolah' => 'SDN Bekasi Jaya 01',
                'alamat'       => 'Jl. Ir. H. Juanda No.12, Bekasi Timur, Kota Bekasi',
                'kuota_porsi'  => 280,
            ],
            [
                'nama_sekolah' => 'SMPN 5 Bekasi',
                'alamat'       => 'Jl. Veteran No.45, Bekasi Selatan, Kota Bekasi',
                'kuota_porsi'  => 350,
            ],
            [
                'nama_sekolah' => 'SDN Mustika Jaya 02',
                'alamat'       => 'Jl. Mustika Raya No.88, Mustika Jaya, Kota Bekasi',
                'kuota_porsi'  => 220,
            ],
            [
                'nama_sekolah' => 'SMAN 3 Bekasi',
                'alamat'       => 'Jl. Bintara Jaya No.7, Bekasi Barat, Kota Bekasi',
                'kuota_porsi'  => 400,
            ],
        ];

        foreach ($schools as $school) {
            School::updateOrCreate(
                ['nama_sekolah' => $school['nama_sekolah']],
                $school
            );
        }
    }
}
