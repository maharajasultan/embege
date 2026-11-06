@extends('admin.layouts.app')

@section('title', 'Edit Transaksi Anggaran')
@section('page-title', 'Edit Transaksi')

@section('content')

<div style="max-width:640px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.budgets.index') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.budgets.update', $budget) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Tanggal Transaksi <span class="required">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $budget->tanggal->format('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Transaksi <span class="required">*</span></label>
                    <select name="jenis" class="form-control" required>
                        <option value="pemasukan" {{ old('jenis', $budget->jenis) == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="pengeluaran" {{ old('jenis', $budget->jenis) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori <span class="required">*</span></label>
                    <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $budget->kategori) }}" required>
                    <div class="form-hint">Dapat diisi manual atau disesuaikan dengan kategori sebelumnya.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nominal (Rp) <span class="required">*</span></label>
                    <input type="number" name="nominal" class="form-control" min="0" step="1" value="{{ old('nominal', $budget->nominal) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $budget->keterangan) }}</textarea>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:20px;">
                    <a href="{{ route('admin.budgets.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
