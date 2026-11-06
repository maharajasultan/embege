@extends('admin.layouts.app')

@section('title', 'Anggaran Bulanan')
@section('page-title', 'Anggaran Bulanan')
@section('page-subtitle', 'Kelola pemasukan dan pengeluaran dapur MBG')

@section('content')

<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div style="flex:1; min-width:200px;">
            <div style="font-size:13px; color:#94a3b8;">Total Pemasukan</div>
            <div style="font-size:24px; font-weight:700; color:#16a34a;">Rp {{ number_format($summary['total_pemasukan'], 0, ',', '.') }}</div>
        </div>
        <div style="flex:1; min-width:200px;">
            <div style="font-size:13px; color:#94a3b8;">Total Pengeluaran</div>
            <div style="font-size:24px; font-weight:700; color:#ef4444;">Rp {{ number_format($summary['total_pengeluaran'], 0, ',', '.') }}</div>
        </div>
        <div style="flex:1; min-width:200px; padding-left:16px; border-left:1px solid #e2e8f0;">
            <div style="font-size:13px; color:#94a3b8;">Saldo Saat Ini</div>
            <div style="font-size:24px; font-weight:700; color:{{ $summary['saldo'] >= 0 ? '#2563eb' : '#ef4444' }};">
                Rp {{ number_format($summary['saldo'], 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

<div style="display:flex; justify-content:flex-end; margin-bottom:16px;">
    <a href="{{ route('admin.budgets.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Transaksi
    </a>
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
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($budgets as $budget)
                <tr>
                    <td style="color:#64748b;">{{ $budget->tanggal->format('d M Y') }}</td>
                    <td style="font-weight:600;">{{ $budget->kategori }}</td>
                    <td style="color:#64748b;">{{ Str::limit($budget->keterangan, 50) }}</td>
                    <td style="text-align:right; color:#16a34a; font-weight:600;">
                        {{ $budget->jenis == 'pemasukan' ? 'Rp ' . number_format($budget->nominal, 0, ',', '.') : '-' }}
                    </td>
                    <td style="text-align:right; color:#ef4444; font-weight:600;">
                        {{ $budget->jenis == 'pengeluaran' ? 'Rp ' . number_format($budget->nominal, 0, ',', '.') : '-' }}
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; justify-content:center;">
                            <a href="{{ route('admin.budgets.edit', $budget) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.budgets.destroy', $budget) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:32px; color:#94a3b8;">
                        Belum ada data transaksi anggaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($budgets->hasPages())
        <div style="padding:16px;">{{ $budgets->links() }}</div>
    @endif
</div>

@endsection
