@extends('admin.layouts.app')

@section('title', 'Manajemen Jadwal Menu')
@section('page-title', 'Jadwal Menu')
@section('page-subtitle', 'Kelola semua jadwal dan menu harian')

@section('content')

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-calendar-days" style="color:#16a34a;margin-right:8px;"></i>Daftar Jadwal Menu</h2>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Jadwal
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Nama Menu</th>
                    <th>Gizi</th>
                    <th>Chef</th>
                    <th>Supir</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $loop->iteration }}</td>
                    <td>
                        <div style="font-weight:600; color:#1e293b;">{{ $menu->hari }}</div>
                        <div style="font-size:12px; color:#94a3b8;">{{ $menu->tanggal_format }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $menu->nama_menu }}</div>
                        @if($menu->daftar_lauk)
                            <div style="font-size:12px; color:#94a3b8; margin-top:3px;">
                                {{ implode(' · ', array_slice($menu->daftar_lauk, 0, 2)) }}
                                @if(count($menu->daftar_lauk) > 2)
                                    <span>+{{ count($menu->daftar_lauk) - 2 }} lagi</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:13px;">
                            <span style="color:#ef4444;">🔥 {{ $menu->kalori }}</span> kal ·
                            <span style="color:#f59e0b;">{{ $menu->karbohidrat }}g karbo</span> ·
                            <span style="color:#3b82f6;">{{ $menu->protein }}g prot</span>
                        </div>
                    </td>
                    <td>
                        @if($menu->chef)
                            <div style="font-size:13px; font-weight:500;">{{ $menu->chef->nama_lengkap }}</div>
                        @else
                            <span style="color:#94a3b8; font-size:12px;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($menu->supir)
                            <div style="font-size:13px; font-weight:500;">{{ $menu->supir->nama_lengkap }}</div>
                        @else
                            <span style="color:#94a3b8; font-size:12px;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($menu->status === 'aktif')
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:6px;"></i> Aktif</span>
                        @elseif($menu->status === 'selesai')
                            <span class="badge badge-gray"><i class="fas fa-circle-check" style="font-size:10px;"></i> Selesai</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-ban" style="font-size:10px;"></i> Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; justify-content:center;">
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus jadwal menu ini?')">
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
                    <td colspan="8" style="text-align:center; padding:40px; color:#94a3b8;">
                        <i class="fas fa-calendar-xmark" style="font-size:32px; margin-bottom:10px; display:block;"></i>
                        Belum ada jadwal menu. <a href="{{ route('admin.menus.create') }}" style="color:#16a34a;">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($menus->hasPages())
        <div style="padding:16px 24px; border-top:1px solid #f1f5f9;">
            {{ $menus->links() }}
        </div>
    @endif
</div>

@endsection
