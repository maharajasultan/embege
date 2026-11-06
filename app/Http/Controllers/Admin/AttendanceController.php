<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Staff;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', today()->toDateString());
        $staffs = Staff::where('status_aktif', true)->orderBy('posisi')->orderBy('nama_lengkap')->get();
        
        $attendances = Attendance::where('tanggal', $tanggal)->get()->keyBy('staff_id');

        return view('admin.attendances.index', compact('staffs', 'attendances', 'tanggal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'attendance' => ['required', 'array'],
            'attendance.*.status' => ['required', 'in:hadir,sakit,izin,alpa'],
            'attendance.*.keterangan' => ['nullable', 'string'],
        ]);

        $tanggal = $validated['tanggal'];

        foreach ($validated['attendance'] as $staff_id => $data) {
            Attendance::updateOrCreate(
                ['staff_id' => $staff_id, 'tanggal' => $tanggal],
                [
                    'status' => $data['status'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.attendances.index', ['tanggal' => $tanggal])
            ->with('success', 'Data absensi berhasil disimpan!');
    }
}
