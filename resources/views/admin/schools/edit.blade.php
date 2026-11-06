@extends('admin.layouts.app')

@section('title', 'Edit Sekolah Mitra')
@section('page-title', 'Edit Sekolah Mitra')
@section('page-subtitle', 'Perbarui data: ' . $school->nama_sekolah)

@section('content')

<div style="max-width:640px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.schools.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-pen" style="color:#d97706;margin-right:8px;"></i>Edit Sekolah: {{ $school->nama_sekolah }}</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.schools.update', $school) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if($school->foto_url)
                    <div style="margin-bottom:12px; display:flex; align-items:center; gap:12px; background:#f8fafc; padding:12px; border-radius:12px; border:1px solid #e2e8f0;">
                        <img src="{{ asset('storage/' . $school->foto_url) }}" alt="Foto Sekolah" style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                        <div>
                            <label style="display:flex; align-items:center; gap:6px; color:#ef4444; font-size:13px; cursor:pointer;">
                                <input type="checkbox" name="hapus_foto" value="1"> Hapus foto
                            </label>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="form-label">Foto Sekolah</label>
                    <input type="file" name="foto" class="form-control" accept="image/jpg,image/jpeg,image/png,image/webp">
                    <div class="form-hint">Upload foto baru untuk mengganti. Format: JPG, PNG, WEBP. Maks: 2MB.</div>
                    @error('foto') <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Sekolah <span class="required">*</span></label>
                    <input type="text" name="nama_sekolah"
                           class="form-control {{ $errors->has('nama_sekolah') ? 'is-invalid' : '' }}"
                           value="{{ old('nama_sekolah', $school->nama_sekolah) }}" required>
                    @error('nama_sekolah')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                    <textarea name="alamat"
                              class="form-control {{ $errors->has('alamat') ? 'is-invalid' : '' }}"
                              rows="3"
                              required>{{ old('alamat', $school->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kuota Porsi per Hari <span class="required">*</span></label>
                    <input type="number" name="kuota_porsi"
                           class="form-control {{ $errors->has('kuota_porsi') ? 'is-invalid' : '' }}"
                           value="{{ old('kuota_porsi', $school->kuota_porsi) }}"
                           min="0" step="1" required>
                    @error('kuota_porsi')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex; gap:12px; justify-content:flex-end; padding-top:20px; border-top:1px solid #f1f5f9;">
                    <a href="{{ route('admin.schools.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
