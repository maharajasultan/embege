@extends('admin.layouts.app')

@section('title', 'Tambah Transaksi Anggaran')
@section('page-title', 'Tambah Transaksi')
@section('page-subtitle', 'Catat pemasukan atau pengeluaran baru')

@section('content')

<div style="max-width:640px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.budgets.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.budgets.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Tanggal Transaksi <span class="required">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Transaksi <span class="required">*</span></label>
                    <select name="jenis" class="form-control" required>
                        <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori <span class="required">*</span></label>
                    <select name="kategori" class="form-control" required>
                        <option value="Donasi">Donasi / Bantuan</option>
                        <option value="Anggaran Pemerintah">Anggaran Pemerintah</option>
                        <option value="Belanja Bahan Pokok">Belanja Bahan Pokok (Sayur, Daging, dll)</option>
                        <option value="Operasional Dapur">Operasional Dapur (Gas, Listrik, Air)</option>
                        <option value="Gaji Karyawan">Gaji Karyawan</option>
                        <option value="Biaya Distribusi">Biaya Distribusi (BBM, dll)</option>
                        <option value="Lain-lain">Lain-lain</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Nominal (Rp) <span class="required">*</span></label>
                    <input type="number" name="nominal" class="form-control" min="0" step="1" value="{{ old('nominal') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:20px;">
                    <a href="{{ route('admin.budgets.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
