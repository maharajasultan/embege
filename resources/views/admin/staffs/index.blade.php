@extends('admin.layouts.app')

@section('title', 'Manajemen Staf')
@section('page-title', 'Staf & Karyawan')
@section('page-subtitle', 'Kelola data seluruh staf dapur MBG')

@push('styles')
<style>
    .staff-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .staff-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }

    .staff-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,.1);
    }

    .staff-card-photo {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: linear-gradient(135deg, #1e293b, #334155);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 52px;
        color: #fff;
        font-weight: 800;
    }

    .staff-card-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .staff-card-body {
        padding: 16px;
    }

    .staff-card-name {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .staff-card-actions {
        display: flex;
        gap: 8px;
        margin-top: 14px;
    }

    .filter-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-bar select {
        padding: 9px 14px;
        border: 1.5px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        color: #374151;
        background: #fff;
        outline: none;
    }

    .count-badge {
        background: #f1f5f9;
        color: #64748b;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <div class="filter-bar" style="margin-bottom:0;">
        <span class="count-badge">{{ $staffs->total() }} staf</span>
        <form method="GET" style="display:flex; gap:8px; flex-wrap:wrap;">
            <select name="posisi" onchange="this.form.submit()">
                <option value="">Semua Posisi</option>
                <option value="manajer" {{ request('posisi') === 'manajer' ? 'selected' : '' }}>Manajer</option>
                <option value="chef"    {{ request('posisi') === 'chef'    ? 'selected' : '' }}>Chef / Koki</option>
                <option value="supir"   {{ request('posisi') === 'supir'   ? 'selected' : '' }}>Driver / Supir</option>
                <option value="staf"    {{ request('posisi') === 'staf'    ? 'selected' : '' }}>Staf Operasional</option>
                <option value="admin"   {{ request('posisi') === 'admin'   ? 'selected' : '' }}>Admin</option>
            </select>
            <select name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </form>
    </div>
    <a href="{{ route('admin.staffs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Staf
    </a>
</div>

@if($staffs->count() > 0)
    <div class="staff-grid">
        @foreach($staffs as $staf)
            <div class="staff-card">
                <div class="staff-card-photo">
                    @if($staf->foto_url)
                        <img src="{{ asset('storage/' . $staf->foto_url) }}" alt="{{ $staf->nama_lengkap }}">
                    @else
                        {{ strtoupper(substr($staf->nama_lengkap, 0, 1)) }}
                    @endif
                </div>
                <div class="staff-card-body">
                    <div class="staff-card-name">{{ $staf->nama_lengkap }}</div>
                    <div style="display:flex; gap:6px; flex-wrap:wrap; margin-top:6px;">
                        @php
                            $posisiColor = match($staf->posisi) {
                                'chef'    => 'badge-warning',
                                'supir'   => 'badge-info',
                                'manajer' => 'badge-success',
                                default   => 'badge-gray',
                            };
                        @endphp
                        <span class="badge {{ $posisiColor }}">{{ $staf->posisi_label }}</span>
                        @if($staf->status_aktif)
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:5px;"></i> Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </div>
                    <div class="staff-card-actions">
                        <a href="{{ route('admin.staffs.edit', $staf) }}" class="btn btn-warning btn-sm" style="flex:1; justify-content:center;">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.staffs.destroy', $staf) }}"
                              onsubmit="return confirm('Yakin ingin menghapus staf {{ $staf->nama_lengkap }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($staffs->hasPages())
        <div style="margin-top:24px;">{{ $staffs->appends(request()->query())->links() }}</div>
    @endif
@else
    <div class="card">
        <div class="card-body" style="text-align:center; padding:60px;">
            <div style="font-size:48px; margin-bottom:12px;">👥</div>
            <h3 style="color:#374151; margin-bottom:8px;">Belum ada staf terdaftar</h3>
            <p style="color:#94a3b8; margin-bottom:20px;">Tambahkan staf pertama untuk memulai.</p>
            <a href="{{ route('admin.staffs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Staf Sekarang
            </a>
        </div>
    </div>
@endif

@endsection
