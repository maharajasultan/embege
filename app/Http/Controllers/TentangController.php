<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\School;

class TentangController extends Controller
{
    public function index()
    {
        // Profil Dapur (static)
        $profil = [
            'nama'      => 'Dapur MBG Bekasi',
            'lokasi'    => 'Jl. Raya Bekasi No. 45, Kelurahan Margahayu, Kecamatan Bekasi Timur, Kota Bekasi, Jawa Barat 17113',
            'telepon'   => '(021) 8800-1234',
            'email'     => 'dapur.mbg.bekasi@gmail.com',
            'visi'      => 'Menjadi dapur produksi makanan bergizi terpercaya yang mendukung tumbuh kembang generasi Indonesia yang sehat, cerdas, dan berprestasi.',
            'misi'      => [
                'Menyediakan makanan bergizi sesuai standar gizi nasional untuk siswa sekolah.',
                'Menjaga kualitas, kebersihan, dan keamanan pangan dalam setiap proses produksi.',
                'Mendistribusikan makanan tepat waktu ke seluruh sekolah mitra dengan sistem yang terorganisir.',
                'Mewujudkan transparansi informasi kepada publik mengenai program MBG.',
            ],
            'kapasitas' => number_format(School::sum('kuota_porsi')) . ' porsi/hari',
            'berdiri'   => '2024',
        ];

        // Data Staf dari database
        $staffFromDb = Staff::where('status_aktif', true)
            ->orderByRaw("FIELD(posisi, 'manajer', 'chef', 'staf', 'admin', 'supir')")
            ->get();

        $posisiColor = [
            'manajer' => '#16a34a',
            'chef'    => '#f97316',
            'supir'   => '#d97706',
            'admin'   => '#0ea5e9',
            'staf'    => '#64748b',
        ];

        $staf = $staffFromDb->map(function ($s) use ($posisiColor) {
            return [
                'id'     => $s->id,
                'nama'   => $s->nama_lengkap,
                'posisi' => $s->posisi_label,
                'foto'   => $s->foto,
                'warna'  => $posisiColor[$s->posisi] ?? '#64748b',
                'bio'    => '',
            ];
        })->all();

        // Data Sekolah Mitra dari database
        $schoolsFromDb = School::orderBy('nama_sekolah')->get();

        $sekolah = $schoolsFromDb->map(function ($s) {
            $tingkat = 'SD';
            if (str_contains(strtolower($s->nama_sekolah), 'smp')) $tingkat = 'SMP';
            elseif (str_contains(strtolower($s->nama_sekolah), 'sma') || str_contains(strtolower($s->nama_sekolah), 'smk')) $tingkat = 'SMA';
            elseif (str_contains(strtolower($s->nama_sekolah), 'universitas') || str_contains(strtolower($s->nama_sekolah), 'stia')) $tingkat = 'PT';

            return [
                'id'      => $s->id,
                'nama'    => $s->nama_sekolah,
                'alamat'  => $s->alamat,
                'kuota'   => $s->kuota_porsi,
                'tingkat' => $tingkat,
                'emoji'   => in_array($tingkat, ['SMA', 'SMP', 'PT']) ? '🏛️' : '🏫',
                'foto'    => $s->foto,
            ];
        })->all();

        return view('tentang', compact('profil', 'staf', 'sekolah'));
    }
}
