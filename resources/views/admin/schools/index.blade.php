@extends('admin.layouts.app')

@section('title', 'Sekolah Mitra')
@section('page-title', 'Sekolah Mitra')
@section('page-subtitle', 'Kelola daftar sekolah penerima distribusi MBG')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <div>
        <span style="background:#f1f5f9; color:#64748b; padding:4px 12px; border-radius:20px; font-size:13px; font-weight:600;">
            {{ $schools->total() }} sekolah
        </span>
    </div>
    <a href="{{ route('admin.schools.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Sekolah
    </a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Sekolah</th>
                    <th>Alamat</th>
                    <th style="text-align:center;">Kuota Porsi</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schools as $school)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; background:#dbeafe; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-school" style="color:#2563eb; font-size:14px;"></i>
                            </div>
                            <span style="font-weight:600; color:#1e293b;">{{ $school->nama_sekolah }}</span>
                        </div>
                    </td>
                    <td style="max-width:280px; color:#64748b; font-size:13px;">{{ $school->alamat }}</td>
                    <td style="text-align:center;">
                        <span style="display:inline-flex; align-items:center; gap:6px; background:#f0fdf4; color:#16a34a; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:700; border:1px solid #dcfce7;">
                            <i class="fas fa-bowl-food" style="font-size:11px;"></i>
                            {{ number_format($school->kuota_porsi) }} porsi
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; justify-content:center;">
                            <a href="{{ route('admin.schools.edit', $school) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.schools.destroy', $school) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus sekolah {{ $school->nama_sekolah }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:48px; color:#94a3b8;">
                        <i class="fas fa-school" style="font-size:36px; margin-bottom:10px; display:block;"></i>
                        Belum ada sekolah mitra terdaftar.
                        <a href="{{ route('admin.schools.create') }}" style="color:#16a34a; margin-left:4px;">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($schools->hasPages())
        <div style="padding:16px 24px; border-top:1px solid #f1f5f9;">
            {{ $schools->links() }}
        </div>
    @endif
</div>

{{-- Summary Card --}}
@if($schools->count() > 0)
<div class="card" style="margin-top:20px;">
    <div class="card-body" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
        <div>
            <div style="font-size:13px; color:#94a3b8; margin-bottom:4px;">Total Kuota Porsi Keseluruhan</div>
            <div style="font-size:28px; font-weight:800; color:#16a34a;">
                {{ number_format($schools->sum('kuota_porsi')) }}
                <span style="font-size:16px; font-weight:600; color:#64748b;">porsi/hari</span>
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:13px; color:#94a3b8; margin-bottom:4px;">Jumlah Sekolah Mitra</div>
            <div style="font-size:28px; font-weight:800; color:#2563eb;">{{ $schools->total() }} sekolah</div>
        </div>
    </div>
</div>
@endif

@endsection
