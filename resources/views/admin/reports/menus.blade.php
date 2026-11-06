@extends('admin.layouts.app')

@section('title', 'Laporan Bulanan Menu')
@section('page-title', 'Laporan Bulanan: Menu & Porsi')
@section('page-subtitle', 'Rekapitulasi jadwal menu dan total porsi yang didistribusikan')

@section('content')

<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.menus') }}" style="display:flex; gap:12px; align-items:flex-end;">
            <div class="form-group" style="margin-bottom:0; width:200px;">
                <label class="form-label">Bulan & Tahun</label>
                <input type="month" name="bulan_tahun" class="form-control" value="{{ $bulan_tahun }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
            <button type="button" class="btn btn-outline" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
        </form>
    </div>
</div>

<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="display:flex; gap:20px; flex-wrap:wrap;">
        <div style="flex:1; min-width:200px; padding:16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px;">
            <div style="font-size:13px; color:#16a34a; margin-bottom:4px; font-weight:600;">Total Hari Masak & Distribusi (Selesai)</div>
            <div style="font-size:32px; font-weight:800; color:#15803d;">{{ $total_hari }} <span style="font-size:16px; font-weight:600;">hari</span></div>
        </div>
        <div style="flex:1; min-width:200px; padding:16px; background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px;">
            <div style="font-size:13px; color:#2563eb; margin-bottom:4px; font-weight:600;">Total Porsi Terdestribusi Bulan Ini</div>
            <div style="font-size:32px; font-weight:800; color:#1d4ed8;">{{ number_format($total_porsi, 0, ',', '.') }} <span style="font-size:16px; font-weight:600;">porsi</span></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Menu</th>
                    <th style="text-align:center;">Kalori</th>
                    <th>Chef / Supir</th>
                    <th style="text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td style="color:#64748b;">{{ $menu->tanggal->format('d M Y') }}</td>
                    <td style="font-weight:600;">{{ $menu->nama_menu }}</td>
                    <td style="text-align:center;">{{ $menu->kalori }} kcal</td>
                    <td>
                        <div style="font-size:12px; color:#64748b;"><i class="fas fa-fire-burner"></i> {{ $menu->chef->nama_lengkap ?? '-' }}</div>
                        <div style="font-size:12px; color:#64748b;"><i class="fas fa-truck"></i> {{ $menu->supir->nama_lengkap ?? '-' }}</div>
                    </td>
                    <td style="text-align:center;">
                        @if($menu->status == 'selesai')
                            <span class="badge badge-success">Selesai</span>
                        @elseif($menu->status == 'aktif')
                            <span class="badge badge-info">Aktif</span>
                        @else
                            <span class="badge badge-danger">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:32px;">Tidak ada jadwal menu di bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
