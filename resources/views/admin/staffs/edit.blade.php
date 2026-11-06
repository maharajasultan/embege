@extends('admin.layouts.app')

@section('title', 'Edit Staf: ' . $staff->nama_lengkap)
@section('page-title', 'Edit Staf')
@section('page-subtitle', 'Perbarui data: ' . $staff->nama_lengkap)

@push('styles')
<style>
    .current-photo-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 16px;
    }

    .current-photo {
        width: 80px; height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #dcfce7;
        flex-shrink: 0;
        background: linear-gradient(135deg, #1e293b, #334155);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 28px; font-weight: 800;
        overflow: hidden;
    }
    .current-photo img { width: 100%; height: 100%; object-fit: cover; }

    .current-photo-info strong { display: block; font-size: 14px; font-weight: 600; color: #1e293b; }
    .current-photo-info span { font-size: 12px; color: #94a3b8; }

    .upload-area {
        width: 100%;
        border: 2px dashed #d1d5db;
        border-radius: 14px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: all .2s;
        background: #fafafa;
        position: relative;
    }

    .upload-area:hover { border-color: #16a34a; background: #f0fdf4; }

    .upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-icon { font-size: 28px; color: #94a3b8; margin-bottom: 8px; }
    .upload-text  { font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 4px; }
    .upload-hint  { font-size: 12px; color: #94a3b8; }

    .preview-wrapper { display:none; text-align:center; margin-top:12px; }
    .preview-wrapper.visible { display:block; }
    .preview-img {
        width: 100px; height: 100px;
        border-radius: 50%; object-fit: cover;
        border: 3px solid #dcfce7;
        margin-bottom: 8px;
    }

    .form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    @media(max-width:640px) { .form-grid-2 { grid-template-columns:1fr; } }

    .section-title {
        font-size: 13px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .06em;
        color: #94a3b8;
        padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;
        margin-bottom: 20px;
    }

    .toggle-label { display:flex; align-items:center; gap:12px; cursor:pointer; }
    .toggle-switch { position:relative; width:48px; height:26px; }
    .toggle-switch input { opacity:0; width:0; height:0; }
    .toggle-slider { position:absolute; inset:0; background:#d1d5db; border-radius:26px; transition:.3s; }
    .toggle-slider::before {
        content:''; position:absolute;
        width:20px; height:20px; border-radius:50%;
        background:white; bottom:3px; left:3px; transition:.3s;
        box-shadow:0 1px 3px rgba(0,0,0,.2);
    }
    .toggle-switch input:checked + .toggle-slider { background:#16a34a; }
    .toggle-switch input:checked + .toggle-slider::before { transform:translateX(22px); }
    .toggle-text { font-size:14px; font-weight:500; color:#374151; }

    .delete-photo-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #ef4444;
        cursor: pointer;
        margin-top: 10px;
    }
    .delete-photo-label input { accent-color: #ef4444; }
</style>
@endpush

@section('content')

<div style="max-width:700px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.staffs.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-pen" style="color:#d97706;margin-right:8px;"></i>Edit Data Staf</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.staffs.update', $staff) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Foto Saat Ini --}}
                <div class="section-title">📸 Foto Profil</div>

                @if($staff->foto_url)
                    <div class="current-photo-wrap">
                        <div class="current-photo">
                            <img src="{{ asset('storage/' . $staff->foto_url) }}" alt="{{ $staff->nama_lengkap }}">
                        </div>
                        <div class="current-photo-info">
                            <strong>Foto Saat Ini</strong>
                            <span>Upload foto baru untuk mengganti</span>
                        </div>
                    </div>

                    <label class="delete-photo-label">
                        <input type="checkbox" name="hapus_foto" value="1">
                        <i class="fas fa-trash" style="font-size:12px;"></i>
                        Hapus foto (tidak akan ada foto)
                    </label>
                    <br>
                @endif

                <div class="upload-area" id="uploadArea" style="margin-top:12px;">
                    <input type="file" name="foto" id="fotoInput" accept="image/jpg,image/jpeg,image/png,image/webp">
                    <div id="uploadPlaceholder">
                        <div class="upload-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                        <div class="upload-text">{{ $staff->foto_url ? 'Klik untuk ganti foto' : 'Klik atau seret foto ke sini' }}</div>
                        <div class="upload-hint">Format: JPG, PNG, WEBP · Maks. 2MB</div>
                    </div>
                </div>

                @error('foto')
                    <div class="invalid-feedback" style="margin-top:8px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror

                <div class="preview-wrapper" id="previewWrapper">
                    <img id="previewImg" class="preview-img" src="" alt="Preview">
                    <div style="font-size:12px; color:#94a3b8;" id="previewFileName"></div>
                    <button type="button" onclick="clearPhoto()" style="font-size:12px; color:#ef4444; background:none; border:none; cursor:pointer; margin-top:4px;">
                        <i class="fas fa-times"></i> Batal pilih
                    </button>
                </div>

                {{-- Data Diri --}}
                <div class="section-title" style="margin-top:28px;">👤 Data Diri</div>

                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_lengkap"
                           class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}"
                           value="{{ old('nama_lengkap', $staff->nama_lengkap) }}" required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Jabatan / Posisi <span class="required">*</span></label>
                        <select name="posisi" class="form-control" required>
                            <option value="manajer" {{ old('posisi', $staff->posisi) === 'manajer' ? 'selected' : '' }}>🏆 Manajer Dapur</option>
                            <option value="chef"    {{ old('posisi', $staff->posisi) === 'chef'    ? 'selected' : '' }}>👨‍🍳 Chef / Koki</option>
                            <option value="supir"   {{ old('posisi', $staff->posisi) === 'supir'   ? 'selected' : '' }}>🚚 Driver / Supir</option>
                            <option value="staf"    {{ old('posisi', $staff->posisi) === 'staf'    ? 'selected' : '' }}>👷 Staf Operasional</option>
                            <option value="admin"   {{ old('posisi', $staff->posisi) === 'admin'   ? 'selected' : '' }}>💼 Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status Kepegawaian</label>
                        <div style="padding:10px 0;">
                            <label class="toggle-label">
                                <div class="toggle-switch">
                                    <input type="checkbox" name="status_aktif" value="1"
                                           {{ old('status_aktif', $staff->status_aktif) ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </div>
                                <span class="toggle-text">Staf Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:12px; justify-content:flex-end; padding-top:20px; border-top:1px solid #f1f5f9;">
                    <a href="{{ route('admin.staffs.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const fotoInput = document.getElementById('fotoInput');
    const previewImg = document.getElementById('previewImg');
    const previewWrapper = document.getElementById('previewWrapper');
    const previewFileName = document.getElementById('previewFileName');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');

    fotoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewWrapper.classList.add('visible');
            previewFileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            uploadPlaceholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    function clearPhoto() {
        fotoInput.value = '';
        previewWrapper.classList.remove('visible');
        uploadPlaceholder.style.display = '';
    }
</script>
@endpush
