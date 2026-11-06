@extends('admin.layouts.app')

@section('title', 'Laporan Bulanan Anggaran')
@section('page-title', 'Laporan Keuangan & Anggaran')
@section('page-subtitle', 'Rekapitulasi arus kas dapur MBG')

@section('content')

<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.budgets') }}" style="display:flex; gap:12px; align-items:flex-end;">
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
    <div class="card-body" style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div style="flex:1; min-width:200px;">
            <div style="font-size:13px; color:#94a3b8;">Total Pemasukan</div>
            <div style="font-size:28px; font-weight:800; color:#16a34a;">Rp {{ number_format($pemasukan, 0, ',', '.') }}</div>
        </div>
        <div style="flex:1; min-width:200px;">
            <div style="font-size:13px; color:#94a3b8;">Total Pengeluaran</div>
            <div style="font-size:28px; font-weight:800; color:#ef4444;">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</div>
        </div>
        <div style="flex:1; min-width:200px; padding-left:16px; border-left:1px solid #e2e8f0;">
            <div style="font-size:13px; color:#94a3b8;">Surplus / (Defisit)</div>
            <div style="font-size:28px; font-weight:800; color:{{ $saldo >= 0 ? '#2563eb' : '#ef4444' }};">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th style="text-align:right;">Pemasukan</th>
                    <th style="text-align:right;">Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($budgets as $budget)
                <tr>
                    <td style="color:#64748b;">{{ $budget->tanggal->format('d M Y') }}</td>
                    <td style="font-weight:600;">{{ $budget->kategori }}</td>
                    <td style="color:#64748b;">{{ $budget->keterangan }}</td>
                    <td style="text-align:right; color:#16a34a; font-weight:600;">
                        {{ $budget->jenis == 'pemasukan' ? 'Rp ' . number_format($budget->nominal, 0, ',', '.') : '-' }}
                    </td>
                    <td style="text-align:right; color:#ef4444; font-weight:600;">
                        {{ $budget->jenis == 'pengeluaran' ? 'Rp ' . number_format($budget->nominal, 0, ',', '.') : '-' }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:32px;">Tidak ada transaksi di bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
