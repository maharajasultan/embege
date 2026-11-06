@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,.07);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,.1);
    }

    .stat-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon.green { background: #dcfce7; color: #16a34a; }
    .stat-icon.blue  { background: #dbeafe; color: #2563eb; }
    .stat-icon.orange{ background: #fef3c7; color: #d97706; }
    .stat-icon.purple{ background: #ede9fe; color: #7c3aed; }

    .stat-info .number {
        font-size: 30px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .stat-info .label {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
        font-weight: 500;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 24px;
    }

    @media (max-width: 900px) {
        .content-grid { grid-template-columns: 1fr; }
    }

    .menu-row-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .menu-row-item:last-child { border-bottom: none; }

    .menu-row-left .menu-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .menu-row-left .menu-date {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .staff-avatar-row {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        padding: 4px 0;
    }

    .staff-chip {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .staff-chip .av {
        width: 36px; height: 36px;
        border-radius: 50%;
        object-fit: cover;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        display: flex; align-items: center; justify-content: center;
        color: white;
        font-size: 13px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .staff-chip .av img {
        width: 36px; height: 36px;
        border-radius: 50%;
        object-fit: cover;
    }

    .staff-chip .info .name { font-size: 13px; font-weight: 600; color: #1e293b; }
    .staff-chip .info .pos  { font-size: 11px; color: #94a3b8; }

    .empty-state {
        text-align: center;
        padding: 32px;
        color: #94a3b8;
    }

    .empty-state i { font-size: 32px; margin-bottom: 10px; display: block; }
    .empty-state p { font-size: 14px; }
</style>
@endpush

@section('content')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-bowl-food"></i></div>
        <div class="stat-info">
            <div class="number">{{ $stats['total_menu'] }}</div>
            <div class="label">Total Jadwal Menu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
        <div class="stat-info">
            <div class="number">{{ $stats['staf_aktif'] }}</div>
            <div class="label">Staf Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-school"></i></div>
        <div class="stat-info">
            <div class="number">{{ $stats['sekolah_mitra'] }}</div>
            <div class="label">Sekolah Mitra</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-utensils"></i></div>
        <div class="stat-info">
            <div class="number">{{ $stats['menu_hari_ini'] }}</div>
            <div class="label">Menu Hari Ini</div>
        </div>
    </div>
</div>

<div class="content-grid">
    {{-- Recent Menus --}}
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-calendar-days" style="color:#16a34a;margin-right:8px;"></i>Jadwal Menu Terbaru</h2>
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        <div class="card-body" style="padding-top:8px; padding-bottom:8px;">
            @forelse($menuTerbaru as $menu)
                <div class="menu-row-item">
                    <div class="menu-row-left">
                        <div class="menu-name">{{ $menu->nama_menu }}</div>
                        <div class="menu-date">
                            {{ $menu->hari }}, {{ $menu->tanggal_format }}
                            @if($menu->chef)
                                · Chef: {{ $menu->chef->nama_lengkap }}
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($menu->status === 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @elseif($menu->status === 'selesai')
                            <span class="badge badge-gray">Selesai</span>
                        @else
                            <span class="badge badge-danger">Dibatalkan</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-bowl-food"></i>
                    <p>Belum ada jadwal menu</p>
                </div>
            @endforelse
        </div>
        @if($menuTerbaru->count() > 0)
        <div style="padding:12px 24px; border-top:1px solid #f1f5f9; text-align:center;">
            <a href="{{ route('admin.menus.index') }}" style="font-size:13px; color:#16a34a; font-weight:600; text-decoration:none;">
                Lihat semua jadwal <i class="fas fa-arrow-right" style="font-size:11px;"></i>
            </a>
        </div>
        @endif
    </div>

    {{-- Active Staff --}}
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-users" style="color:#2563eb;margin-right:8px;"></i>Staf Aktif</h2>
            <a href="{{ route('admin.staffs.create') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
        <div class="card-body">
            @forelse($stafAktif as $staf)
                <div class="staff-chip" style="margin-bottom:10px;">
                    <div class="av">
                        @if($staf->foto_url)
                            <img src="{{ asset('storage/' . $staf->foto_url) }}" alt="{{ $staf->nama_lengkap }}">
                        @else
                            {{ strtoupper(substr($staf->nama_lengkap, 0, 1)) }}
                        @endif
                    </div>
                    <div class="info">
                        <div class="name">{{ $staf->nama_lengkap }}</div>
                        <div class="pos">{{ $staf->posisi_label }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>Belum ada staf terdaftar</p>
                </div>
            @endforelse

            @if($stafAktif->count() > 0)
                <a href="{{ route('admin.staffs.index') }}" style="display:block; text-align:center; font-size:13px; color:#16a34a; font-weight:600; text-decoration:none; margin-top:12px;">
                    Kelola semua staf <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                </a>
            @endif
        </div>
    </div>
</div>

@endsection
