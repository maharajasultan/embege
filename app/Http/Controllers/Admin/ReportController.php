<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Budget;
use App\Models\Salary;
use App\Models\School;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function menus(Request $request)
    {
        $bulan_tahun = $request->input('bulan_tahun', date('Y-m'));
        list($tahun, $bulan) = explode('-', $bulan_tahun);

        $menus = Menu::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal')
            ->get();

        $kuota_harian = School::sum('kuota_porsi');
        $total_hari = $menus->where('status', 'selesai')->count();
        $total_porsi = $total_hari * $kuota_harian;

        return view('admin.reports.menus', compact('menus', 'bulan_tahun', 'total_hari', 'total_porsi'));
    }

    public function budgets(Request $request)
    {
        $bulan_tahun = $request->input('bulan_tahun', date('Y-m'));
        list($tahun, $bulan) = explode('-', $bulan_tahun);

        $budgets = Budget::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->orderBy('tanggal')
            ->get();

        $pemasukan = $budgets->where('jenis', 'pemasukan')->sum('nominal');
        $pengeluaran = $budgets->where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $pemasukan - $pengeluaran;

        return view('admin.reports.budgets', compact('budgets', 'bulan_tahun', 'pemasukan', 'pengeluaran', 'saldo'));
    }

    public function salaries(Request $request)
    {
        $bulan_tahun = $request->input('bulan_tahun', date('Y-m'));

        $salaries = Salary::with('staff')
            ->where('bulan_tahun', $bulan_tahun)
            ->get();

        $total_gaji = $salaries->sum('total_bersih');
        $sudah_dibayar = $salaries->where('status_pembayaran', 'sudah dibayar')->sum('total_bersih');
        $belum_dibayar = $salaries->where('status_pembayaran', 'belum dibayar')->sum('total_bersih');

        return view('admin.reports.salaries', compact('salaries', 'bulan_tahun', 'total_gaji', 'sudah_dibayar', 'belum_dibayar'));
    }
}
