@extends('admin.layouts.app')

@section('title', 'Tambah Staf')
@section('page-title', 'Tambah Staf')
@section('page-subtitle', 'Daftarkan anggota staf baru beserta foto')

@push('styles')
<style>
    .upload-area {
        width: 100%;
        border: 2px dashed #d1d5db;
        border-radius: 14px;
        padding: 32px 24px;
        text-align: center;
        cursor: pointer;
        transition: all .2s;
        background: #fafafa;
        position: relative;
    }

    .upload-area:hover, .upload-area.dragging {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-icon { font-size: 36px; color: #94a3b8; margin-bottom: 12px; }
    .upload-text { font-size: 15px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .upload-hint { font-size: 13px; color: #94a3b8; }

    .preview-wrapper {
        display: none;
        text-align: center;
        margin-top: 16px;
    }

    .preview-wrapper.visible { display: block; }

    .preview-img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #dcfce7;
        box-shadow: 0 4px 16px rgba(0,0,0,.1);
        margin-bottom: 10px;
    }

    .preview-name {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    .btn-remove-preview {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 8px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #ef4444;
        font-size: 12px;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        margin-top: 8px;
    }

    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media(max-width:640px) { .form-grid-2 { grid-template-columns: 1fr; } }
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

    .toggle-label {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
    }

    .toggle-switch {
        position: relative;
        width: 48px; height: 26px;
    }

    .toggle-switch input { opacity: 0; width: 0; height: 0; }

    .toggle-slider {
        position: absolute;
        inset: 0;
        background: #d1d5db;
        border-radius: 26px;
        transition: .3s;
    }

    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: white;
        bottom: 3px; left: 3px;
        transition: .3s;
        box-shadow: 0 1px 3px rgba(0,0,0,.2);
    }

    .toggle-switch input:checked + .toggle-slider { background: #16a34a; }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(22px); }
    .toggle-text { font-size: 14px; font-weight: 500; color: #374151; }
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
            <h2><i class="fas fa-user-plus" style="color:#16a34a;margin-right:8px;"></i>Form Tambah Staf</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.staffs.store') }}" enctype="multipart/form-data" id="staffForm">
                @csrf

                {{-- Foto Upload --}}
                <div class="section-title">📸 Foto Profil</div>

                <div class="upload-area" id="uploadArea">
                    <input type="file" name="foto" id="fotoInput" accept="image/jpg,image/jpeg,image/png,image/webp">
                    <div id="uploadPlaceholder">
                        <div class="upload-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                        <div class="upload-text">Klik atau seret foto ke sini</div>
                        <div class="upload-hint">Format: JPG, PNG, WEBP · Maks. 2MB</div>
                    </div>
                </div>

                @error('foto')
                    <div class="invalid-feedback" style="margin-top:8px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror

                <div class="preview-wrapper" id="previewWrapper">
                    <img id="previewImg" class="preview-img" src="" alt="Preview Foto">
                    <div class="preview-name" id="previewFileName"></div>
                    <button type="button" class="btn-remove-preview" onclick="clearPhoto()">
                        <i class="fas fa-times"></i> Hapus foto
                    </button>
                </div>

                {{-- Data Diri --}}
                <div class="section-title" style="margin-top:28px;">👤 Data Diri</div>

                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_lengkap"
                           class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}"
                           value="{{ old('nama_lengkap') }}"
                           placeholder="Masukkan nama lengkap staf"
                           required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Jabatan / Posisi <span class="required">*</span></label>
                        <select name="posisi" class="form-control {{ $errors->has('posisi') ? 'is-invalid' : '' }}" required>
                            <option value="">— Pilih Jabatan —</option>
                            <option value="manajer" {{ old('posisi') === 'manajer' ? 'selected' : '' }}>🏆 Manajer Dapur</option>
                            <option value="chef"    {{ old('posisi') === 'chef'    ? 'selected' : '' }}>👨‍🍳 Chef / Koki</option>
                            <option value="supir"   {{ old('posisi') === 'supir'   ? 'selected' : '' }}>🚚 Driver / Supir</option>
                            <option value="staf"    {{ old('posisi') === 'staf'    ? 'selected' : '' }}>👷 Staf Operasional</option>
                            <option value="admin"   {{ old('posisi') === 'admin'   ? 'selected' : '' }}>💼 Admin</option>
                        </select>
                        @error('posisi')
                            <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Kepegawaian</label>
                        <div style="padding:10px 0;">
                            <label class="toggle-label">
                                <div class="toggle-switch">
                                    <input type="checkbox" name="status_aktif" value="1"
                                           {{ old('status_aktif', 1) ? 'checked' : '' }}>
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
                        <i class="fas fa-save"></i> Simpan Staf
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
    const uploadArea = document.getElementById('uploadArea');

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

    // Drag and drop
    uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('dragging'); });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragging'));
    uploadArea.addEventListener('drop', e => {
        e.preventDefault();
        uploadArea.classList.remove('dragging');
        fotoInput.files = e.dataTransfer.files;
        fotoInput.dispatchEvent(new Event('change'));
    });
</script>
@endpush
