@extends('admin.layouts.app')

@section('title', 'Gaji Bulanan')
@section('page-title', 'Gaji Bulanan Karyawan')
@section('page-subtitle', 'Generate dan kelola gaji berdasarkan absensi')

@section('content')

<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px;">
        <form method="GET" action="{{ route('admin.salaries.index') }}" style="display:flex; gap:12px; align-items:flex-end;">
            <div class="form-group" style="margin-bottom:0; width:200px;">
                <label class="form-label">Bulan & Tahun</label>
                <input type="month" name="bulan_tahun" class="form-control" value="{{ $bulan_tahun }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
        </form>

        <form method="POST" action="{{ route('admin.salaries.generate') }}" onsubmit="return confirm('Generate gaji untuk bulan {{ $bulan_tahun }}? Data yang sudah ada untuk bulan ini akan diperbarui (Tunjangan & Potongan manual akan keriset!).')">
            @csrf
            <input type="hidden" name="bulan_tahun" value="{{ $bulan_tahun }}">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-rotate"></i> Generate dari Absensi
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Nama Staf</th>
                    <th style="text-align:center;">Hadir</th>
                    <th style="text-align:right;">Gaji Pokok</th>
                    <th style="text-align:right;">Tunj. Hadir</th>
                    <th style="text-align:right;">Potongan</th>
                    <th style="text-align:right;">Total Bersih</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaries as $salary)
                <tr>
                    <td>
                        <div style="font-weight:600; color:#1e293b;">{{ $salary->staff->nama_lengkap }}</div>
                        <div style="font-size:12px; color:#64748b;">{{ $salary->staff->posisi_label }}</div>
                    </td>
                    <td style="text-align:center; font-weight:700;">{{ $salary->jumlah_hadir }}x</td>
                    <td style="text-align:right; color:#64748b;">Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                    <td style="text-align:right; color:#16a34a;">Rp {{ number_format($salary->tunjangan, 0, ',', '.') }}</td>
                    <td style="text-align:right; color:#ef4444;">Rp {{ number_format($salary->potongan, 0, ',', '.') }}</td>
                    <td style="text-align:right; font-weight:700; color:#2563eb;">Rp {{ number_format($salary->total_bersih, 0, ',', '.') }}</td>
                    <td style="text-align:center;">
                        @if($salary->status_pembayaran == 'sudah dibayar')
                            <span style="background:#dcfce7; color:#16a34a; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;"><i class="fas fa-check-circle"></i> Sudah</span>
                        @else
                            <span style="background:#fee2e2; color:#ef4444; padding:4px 10px; border-radius:20px; font-size:12px; font-weight:600;">Belum</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; justify-content:center;">
                            <a href="{{ route('admin.salaries.edit', $salary) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pen"></i> Sesuaikan
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:32px; color:#94a3b8;">
                        Belum ada data gaji untuk bulan ini. Silakan klik tombol "Generate dari Absensi" di atas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
