@extends('admin.layouts.app')

@section('title', 'Tambah Sekolah Mitra')
@section('page-title', 'Tambah Sekolah Mitra')
@section('page-subtitle', 'Daftarkan sekolah baru sebagai mitra distribusi')

@section('content')

<div style="max-width:640px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.schools.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-school" style="color:#2563eb;margin-right:8px;"></i>Form Tambah Sekolah Mitra</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.schools.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Foto Sekolah</label>
                    <input type="file" name="foto" class="form-control" accept="image/jpg,image/jpeg,image/png,image/webp">
                    <div class="form-hint">Format: JPG, PNG, WEBP. Maks: 2MB. Boleh dikosongkan.</div>
                    @error('foto') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Sekolah <span class="required">*</span></label>
                    <input type="text" name="nama_sekolah"
                           class="form-control {{ $errors->has('nama_sekolah') ? 'is-invalid' : '' }}"
                           value="{{ old('nama_sekolah') }}"
                           placeholder="Contoh: SDN Bekasi Jaya 01"
                           required>
                    @error('nama_sekolah')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                    <textarea name="alamat"
                              class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                              rows="3"
                              placeholder="Masukkan alamat lengkap sekolah..."
                              required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kuota Porsi per Hari <span class="required">*</span></label>
                    <input type="number" name="kuota_porsi"
                           class="form-control {{ $errors->has('kuota_porsi') ? 'is-invalid' : '' }}"
                           value="{{ old('kuota_porsi', 0) }}"
                           min="0" step="1"
                           placeholder="Jumlah porsi makan per hari"
                           required>
                    <div class="form-hint">Jumlah total porsi yang dikirim ke sekolah ini setiap harinya.</div>
                    @error('kuota_porsi')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex; gap:12px; justify-content:flex-end; padding-top:20px; border-top:1px solid #f1f5f9;">
                    <a href="{{ route('admin.schools.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Sekolah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
