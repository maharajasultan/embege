<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Staff;
use App\Models\School;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil minggu yang dipilih (default: minggu ini)
        $minggu = request()->input('minggu', 0);
        $startOfWeek = now()->startOfWeek()->addWeeks($minggu);
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        // Jadwal minggu ini dari database
        $jadwalMingguIni = Menu::with(['chef', 'supir'])
            ->whereBetween('tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->orderBy('tanggal')
            ->get()
            ->map(function ($menu) {
                return [
                    'id'        => $menu->id,
                    'tanggal'   => $menu->tanggal->format('Y-m-d'),
                    'hari'      => $menu->hari,
                    'menu_nama' => $menu->nama_menu,
                    'lauk'      => $menu->daftar_lauk ?? [],
                    'kalori'    => $menu->kalori,
                    'karbo'     => $menu->karbohidrat,
                    'protein'   => $menu->protein,
                    'chef'      => $menu->chef ? [
                        'nama'   => $menu->chef->nama_lengkap,
                        'posisi' => $menu->chef->posisi_label,
                        'foto'   => $menu->chef->foto,
                    ] : null,
                    'supir'     => $menu->supir ? [
                        'nama'   => $menu->supir->nama_lengkap,
                        'posisi' => $menu->supir->posisi_label,
                        'foto'   => $menu->supir->foto,
                    ] : null,
                    'status'    => $menu->status,
                    'foto'      => $menu->foto,
                ];
            })
            ->all();

        // Semua jadwal (untuk keperluan display lain)
        $jadwal = $jadwalMingguIni;

        // Statistik dari database
        $stats = [
            'total_porsi'   => School::sum('kuota_porsi'),
            'sekolah_mitra' => School::count(),
            'staf_aktif'    => Staff::where('status_aktif', true)->count(),
            'hari_operasi'  => 5,
        ];

        return view('home', compact('jadwalMingguIni', 'jadwal', 'stats', 'minggu', 'startOfWeek'));
    }
}
