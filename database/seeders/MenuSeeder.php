<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $budi  = Staff::where('nama_lengkap', 'Budi Santoso')->first();
        $siti  = Staff::where('nama_lengkap', 'Siti Rahayu')->first();
        $ahmad = Staff::where('nama_lengkap', 'Ahmad Fauzi')->first();
        $agus  = Staff::where('nama_lengkap', 'Agus Purnama')->first();
        $doni  = Staff::where('nama_lengkap', 'Doni Kusuma')->first();
        $rizky = Staff::where('nama_lengkap', 'Rizky Pratama')->first();

        $menus = [
            [
                'tanggal'     => '2026-06-15',
                'nama_menu'   => 'Nasi Ayam Bumbu Kuning',
                'daftar_lauk' => ['Ayam Bumbu Kuning', 'Tempe Goreng', 'Sayur Bening Bayam', 'Buah Pisang'],
                'kalori'      => 680,
                'karbohidrat' => 85,
                'protein'     => 32,
                'chef_id'     => $budi?->id,
                'supir_id'    => $agus?->id,
                'status'      => 'selesai',
            ],
            [
                'tanggal'     => '2026-06-16',
                'nama_menu'   => 'Nasi Pecel Telur',
                'daftar_lauk' => ['Telur Ceplok', 'Pecel Sayur', 'Tempe Bacem', 'Kerupuk'],
                'kalori'      => 620,
                'karbohidrat' => 80,
                'protein'     => 28,
                'chef_id'     => $siti?->id,
                'supir_id'    => $doni?->id,
                'status'      => 'selesai',
            ],
            [
                'tanggal'     => '2026-06-17',
                'nama_menu'   => 'Nasi Rendang Sapi',
                'daftar_lauk' => ['Rendang Sapi', 'Sayur Nangka', 'Perkedel Jagung', 'Buah Jeruk'],
                'kalori'      => 750,
                'karbohidrat' => 82,
                'protein'     => 38,
                'chef_id'     => $budi?->id,
                'supir_id'    => $agus?->id,
                'status'      => 'selesai',
            ],
            [
                'tanggal'     => '2026-06-18',
                'nama_menu'   => 'Nasi Ikan Bakar Kecap',
                'daftar_lauk' => ['Ikan Bakar Kecap', 'Tahu Goreng', 'Capcay Sayur', 'Buah Semangka'],
                'kalori'      => 640,
                'karbohidrat' => 78,
                'protein'     => 35,
                'chef_id'     => $ahmad?->id,
                'supir_id'    => $rizky?->id,
                'status'      => 'selesai',
            ],
            [
                'tanggal'     => '2026-06-19',
                'nama_menu'   => 'Nasi Soto Ayam',
                'daftar_lauk' => ['Ayam Suwir', 'Soto Kuah Bening', 'Perkedel Kentang', 'Kerupuk Udang'],
                'kalori'      => 590,
                'karbohidrat' => 72,
                'protein'     => 30,
                'chef_id'     => $siti?->id,
                'supir_id'    => $doni?->id,
                'status'      => 'selesai',
            ],
            [
                'tanggal'     => '2026-06-22',
                'nama_menu'   => 'Nasi Opor Ayam',
                'daftar_lauk' => ['Opor Ayam', 'Sambal Goreng Kentang', 'Sayur Lodeh', 'Buah Apel'],
                'kalori'      => 710,
                'karbohidrat' => 88,
                'protein'     => 33,
                'chef_id'     => $budi?->id,
                'supir_id'    => $agus?->id,
                'status'      => 'aktif',
            ],
            [
                'tanggal'     => '2026-06-23',
                'nama_menu'   => 'Nasi Gulai Ikan',
                'daftar_lauk' => ['Gulai Ikan Mas', 'Tempe Mendoan', 'Urap Sayur', 'Buah Mangga'],
                'kalori'      => 660,
                'karbohidrat' => 76,
                'protein'     => 36,
                'chef_id'     => $ahmad?->id,
                'supir_id'    => $rizky?->id,
                'status'      => 'aktif',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['tanggal' => $menu['tanggal'], 'nama_menu' => $menu['nama_menu']],
                $menu
            );
        }
    }
}
