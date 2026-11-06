@extends('admin.layouts.app')

@section('title', 'Laporan Gaji Bulanan')
@section('page-title', 'Laporan Pengeluaran Gaji')
@section('page-subtitle', 'Rekapitulasi beban gaji dan status pembayaran staf')

@section('content')

<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.salaries') }}" style="display:flex; gap:12px; align-items:flex-end;">
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
            <div style="font-size:13px; color:#94a3b8;">Total Beban Gaji</div>
            <div style="font-size:28px; font-weight:800; color:#1e293b;">Rp {{ number_format($total_gaji, 0, ',', '.') }}</div>
        </div>
        <div style="flex:1; min-width:200px;">
            <div style="font-size:13px; color:#94a3b8;">Sudah Dibayar</div>
            <div style="font-size:28px; font-weight:800; color:#16a34a;">Rp {{ number_format($sudah_dibayar, 0, ',', '.') }}</div>
        </div>
        <div style="flex:1; min-width:200px; padding-left:16px; border-left:1px solid #e2e8f0;">
            <div style="font-size:13px; color:#94a3b8;">Belum Dibayar (Hutang)</div>
            <div style="font-size:28px; font-weight:800; color:#ef4444;">Rp {{ number_format($belum_dibayar, 0, ',', '.') }}</div>
        </div>
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
                    <th style="text-align:right;">Tunjangan</th>
                    <th style="text-align:right;">Potongan</th>
                    <th style="text-align:right;">Total Bersih</th>
                    <th style="text-align:center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaries as $salary)
                <tr>
                    <td style="font-weight:600;">{{ $salary->staff->nama_lengkap }}</td>
                    <td style="text-align:center;">{{ $salary->jumlah_hadir }}x</td>
                    <td style="text-align:right;">Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                    <td style="text-align:right;">Rp {{ number_format($salary->tunjangan, 0, ',', '.') }}</td>
                    <td style="text-align:right;">Rp {{ number_format($salary->potongan, 0, ',', '.') }}</td>
                    <td style="text-align:right; font-weight:700;">Rp {{ number_format($salary->total_bersih, 0, ',', '.') }}</td>
                    <td style="text-align:center;">
                        @if($salary->status_pembayaran == 'sudah dibayar')
                            <span style="color:#16a34a; font-weight:600;"><i class="fas fa-check"></i> Lunas</span>
                        @else
                            <span style="color:#ef4444; font-weight:600;"><i class="fas fa-clock"></i> Pending</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center; padding:32px;">Tidak ada data gaji di bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
