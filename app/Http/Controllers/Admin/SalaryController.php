<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Staff;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $bulan_tahun = $request->input('bulan_tahun', date('Y-m'));
        $salaries = Salary::with('staff')
            ->where('bulan_tahun', $bulan_tahun)
            ->get();

        return view('admin.salaries.index', compact('salaries', 'bulan_tahun'));
    }

    public function generate(Request $request)
    {
        $bulan_tahun = $request->input('bulan_tahun', date('Y-m'));
        list($tahun, $bulan) = explode('-', $bulan_tahun);

        $staffs = Staff::where('status_aktif', true)->get();

        foreach ($staffs as $staff) {
            $hadirCount = Attendance::where('staff_id', $staff->id)
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->where('status', 'hadir')
                ->count();

            // Logika dasar penggajian:
            // Manajer: 5jt, Chef: 4jt, Supir: 3.5jt, Admin: 3jt, Staf: 2.5jt
            // Uang kehadiran: 50.000 / hari
            $gaji_pokok = match($staff->posisi) {
                'manajer' => 5000000,
                'chef'    => 4000000,
                'supir'   => 3500000,
                'admin'   => 3000000,
                default   => 2500000,
            };

            $tunjangan = $hadirCount * 50000;
            $potongan = 0;
            $total_bersih = $gaji_pokok + $tunjangan - $potongan;

            Salary::updateOrCreate(
                ['staff_id' => $staff->id, 'bulan_tahun' => $bulan_tahun],
                [
                    'jumlah_hadir' => $hadirCount,
                    'gaji_pokok' => $gaji_pokok,
                    'tunjangan' => $tunjangan,
                    'potongan' => $potongan,
                    'total_bersih' => $total_bersih,
                ]
            );
        }

        return redirect()->route('admin.salaries.index', ['bulan_tahun' => $bulan_tahun])
            ->with('success', 'Data gaji bulan ' . $bulan_tahun . ' berhasil digenerate berdasarkan absen!');
    }

    public function edit(Salary $salary)
    {
        return view('admin.salaries.edit', compact('salary'));
    }

    public function update(Request $request, Salary $salary)
    {
        $validated = $request->validate([
            'gaji_pokok' => ['required', 'numeric', 'min:0'],
            'tunjangan' => ['required', 'numeric', 'min:0'],
            'potongan' => ['required', 'numeric', 'min:0'],
            'status_pembayaran' => ['required', 'in:belum dibayar,sudah dibayar'],
        ]);

        $validated['total_bersih'] = $validated['gaji_pokok'] + $validated['tunjangan'] - $validated['potongan'];

        $salary->update($validated);

        return redirect()->route('admin.salaries.index', ['bulan_tahun' => $salary->bulan_tahun])
            ->with('success', 'Data gaji berhasil diperbarui!');
    }
}
