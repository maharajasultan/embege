@extends('admin.layouts.app')

@section('title', 'Tambah Jadwal Menu')
@section('page-title', 'Tambah Jadwal Menu')
@section('page-subtitle', 'Buat jadwal menu baru')

@push('styles')
<style>
    .lauk-list { display: flex; flex-direction: column; gap: 10px; }
    .lauk-item {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .lauk-item input { flex: 1; }
    .btn-remove-lauk {
        width: 36px; height: 36px;
        border-radius: 8px;
        border: 1.5px solid #fecaca;
        background: #fef2f2;
        color: #ef4444;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: all .2s;
    }
    .btn-remove-lauk:hover { background: #fee2e2; }
    .btn-add-lauk {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1.5px dashed #d1d5db;
        background: transparent;
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all .2s;
        margin-top: 6px;
        font-family: 'Inter', sans-serif;
    }
    .btn-add-lauk:hover { border-color: #16a34a; color: #16a34a; background: #f0fdf4; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media(max-width:640px) { .form-grid { grid-template-columns: 1fr; } }
    .nutrition-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    @media(max-width:480px) { .nutrition-grid { grid-template-columns: 1fr; } }
    .section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #94a3b8;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')

<div style="max-width:860px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.menus.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-plus-circle" style="color:#16a34a;margin-right:8px;"></i>Form Tambah Jadwal Menu</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Foto Menu --}}
                <div class="section-title">📸 Foto Menu</div>
                <div class="form-group">
                    <input type="file" name="foto" class="form-control" accept="image/jpg,image/jpeg,image/png,image/webp">
                    <div class="form-hint">Format: JPG, PNG, WEBP. Maks: 2MB. Boleh dikosongkan.</div>
                    @error('foto') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                {{-- Informasi Dasar --}}
                <div class="section-title" style="margin-top:28px;">📋 Informasi Dasar</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal <span class="required">*</span></label>
                        <input type="date" name="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                               value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        @error('tanggal') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="required">*</span></label>
                        <select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                            <option value="aktif"      {{ old('status') === 'aktif'      ? 'selected' : '' }}>✅ Aktif</option>
                            <option value="selesai"    {{ old('status') === 'selesai'    ? 'selected' : '' }}>✔️ Selesai</option>
                            <option value="dibatalkan" {{ old('status') === 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                        @error('status') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Menu <span class="required">*</span></label>
                    <input type="text" name="nama_menu" class="form-control {{ $errors->has('nama_menu') ? 'is-invalid' : '' }}"
                           value="{{ old('nama_menu') }}" placeholder="Contoh: Nasi Ayam Bumbu Kuning" required>
                    @error('nama_menu') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                {{-- Daftar Lauk --}}
                <div class="section-title" style="margin-top:8px;">🍽️ Daftar Lauk</div>
                <div class="lauk-list" id="laukList">
                    @if(old('daftar_lauk'))
                        @foreach(old('daftar_lauk') as $lauk)
                            <div class="lauk-item">
                                <input type="text" name="daftar_lauk[]" class="form-control" value="{{ $lauk }}" placeholder="Nama lauk...">
                                <button type="button" class="btn-remove-lauk" onclick="removeLauk(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="lauk-item">
                            <input type="text" name="daftar_lauk[]" class="form-control" placeholder="Lauk 1 (misal: Ayam Goreng)">
                            <button type="button" class="btn-remove-lauk" onclick="removeLauk(this)"><i class="fas fa-times"></i></button>
                        </div>
                        <div class="lauk-item">
                            <input type="text" name="daftar_lauk[]" class="form-control" placeholder="Lauk 2 (misal: Tempe Goreng)">
                            <button type="button" class="btn-remove-lauk" onclick="removeLauk(this)"><i class="fas fa-times"></i></button>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn-add-lauk" onclick="addLauk()">
                    <i class="fas fa-plus"></i> Tambah Lauk
                </button>

                {{-- Informasi Gizi --}}
                <div class="section-title" style="margin-top:28px;">⚡ Informasi Gizi</div>
                <div class="nutrition-grid">
                    <div class="form-group">
                        <label class="form-label">Kalori (kal) <span class="required">*</span></label>
                        <input type="number" name="kalori" class="form-control {{ $errors->has('kalori') ? 'is-invalid' : '' }}"
                               value="{{ old('kalori', 0) }}" min="0" required>
                        @error('kalori') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Karbohidrat (gram) <span class="required">*</span></label>
                        <input type="number" name="karbohidrat" class="form-control {{ $errors->has('karbohidrat') ? 'is-invalid' : '' }}"
                               value="{{ old('karbohidrat', 0) }}" min="0" required>
                        @error('karbohidrat') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Protein (gram) <span class="required">*</span></label>
                        <input type="number" name="protein" class="form-control {{ $errors->has('protein') ? 'is-invalid' : '' }}"
                               value="{{ old('protein', 0) }}" min="0" required>
                        @error('protein') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Tim Dapur --}}
                <div class="section-title" style="margin-top:8px;">👨‍🍳 Tim Dapur</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Chef / Koki</label>
                        <select name="chef_id" class="form-control">
                            <option value="">— Pilih Chef —</option>
                            @foreach($chefs as $chef)
                                <option value="{{ $chef->id }}" {{ old('chef_id') == $chef->id ? 'selected' : '' }}>
                                    {{ $chef->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('chef_id') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Driver / Supir</label>
                        <select name="supir_id" class="form-control">
                            <option value="">— Pilih Supir —</option>
                            @foreach($supirs as $supir)
                                <option value="{{ $supir->id }}" {{ old('supir_id') == $supir->id ? 'selected' : '' }}>
                                    {{ $supir->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('supir_id') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                    </div>
                </div>

                <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:12px; padding-top:20px; border-top:1px solid #f1f5f9;">
                    <a href="{{ route('admin.menus.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function addLauk() {
        const list = document.getElementById('laukList');
        const count = list.children.length + 1;
        const div = document.createElement('div');
        div.className = 'lauk-item';
        div.innerHTML = `
            <input type="text" name="daftar_lauk[]" class="form-control" placeholder="Lauk ${count}...">
            <button type="button" class="btn-remove-lauk" onclick="removeLauk(this)">
                <i class="fas fa-times"></i>
            </button>
        `;
        list.appendChild(div);
        div.querySelector('input').focus();
    }

    function removeLauk(btn) {
        const list = document.getElementById('laukList');
        if (list.children.length <= 1) return;
        btn.closest('.lauk-item').remove();
    }
</script>
@endpush
