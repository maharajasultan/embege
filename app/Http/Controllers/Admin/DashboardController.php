<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Staff;
use App\Models\School;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_menu'    => Menu::count(),
            'staf_aktif'    => Staff::where('status_aktif', true)->count(),
            'sekolah_mitra' => School::count(),
            'menu_hari_ini' => Menu::whereDate('tanggal', today())->count(),
        ];

        $menuTerbaru = Menu::with(['chef', 'supir'])
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        $stafAktif = Staff::where('status_aktif', true)->limit(6)->get();

        return view('admin.dashboard', compact('stats', 'menuTerbaru', 'stafAktif'));
    }
}
