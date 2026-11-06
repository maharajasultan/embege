@extends('admin.layouts.app')

@section('title', 'Absensi Harian')
@section('page-title', 'Absensi Harian Karyawan')
@section('page-subtitle', 'Input kehadiran staf dan karyawan per tanggal')

@section('content')

<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.attendances.index') }}" style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
            <div class="form-group" style="margin-bottom:0; flex:1; max-width:300px;">
                <label class="form-label">Pilih Tanggal Absensi</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" max="{{ date('Y-m-d') }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Input Absensi: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h2>
    </div>
    <div class="table-wrapper">
        <form method="POST" action="{{ route('admin.attendances.store') }}">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Staf</th>
                        <th>Posisi</th>
                        <th style="width:250px;">Status Kehadiran</th>
                        <th>Keterangan (Opsional)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffs as $staff)
                    @php 
                        $currentStatus = isset($attendances[$staff->id]) ? $attendances[$staff->id]->status : 'hadir';
                        $currentKet = isset($attendances[$staff->id]) ? $attendances[$staff->id]->keterangan : '';
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="font-weight:600;">{{ $staff->nama_lengkap }}</td>
                        <td>{{ $staff->posisi_label }}</td>
                        <td>
                            <select name="attendance[{{ $staff->id }}][status]" class="form-control" style="padding:6px 10px; font-size:13px;">
                                <option value="hadir" {{ $currentStatus == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                <option value="sakit" {{ $currentStatus == 'sakit' ? 'selected' : '' }}>🤒 Sakit</option>
                                <option value="izin" {{ $currentStatus == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                <option value="alpa" {{ $currentStatus == 'alpa' ? 'selected' : '' }}>❌ Alpa</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="attendance[{{ $staff->id }}][keterangan]" class="form-control" style="padding:6px 10px; font-size:13px;" value="{{ $currentKet }}" placeholder="Keterangan...">
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;">Belum ada staf aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($staffs->count() > 0)
            <div style="padding:20px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end;">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data Absensi</button>
            </div>
            @endif
        </form>
    </div>
</div>

@endsection
