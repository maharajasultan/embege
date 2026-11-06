@extends('admin.layouts.app')

@section('title', 'Sesuaikan Gaji')
@section('page-title', 'Sesuaikan Gaji Staf')
@section('page-subtitle', $salary->staff->nama_lengkap . ' (' . $salary->bulan_tahun . ')')

@section('content')

<div style="max-width:640px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.salaries.index', ['bulan_tahun' => $salary->bulan_tahun]) }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="background:#f1f5f9; padding:16px; border-radius:12px; margin-bottom:24px;">
                <div style="font-size:13px; color:#64748b;">Informasi Kehadiran</div>
                <div style="font-size:16px; font-weight:700; color:#1e293b;">Total Hadir: {{ $salary->jumlah_hadir }} hari</div>
            </div>

            <form method="POST" action="{{ route('admin.salaries.update', $salary) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Gaji Pokok (Rp)</label>
                    <input type="number" name="gaji_pokok" class="form-control" min="0" step="1" value="{{ old('gaji_pokok', $salary->gaji_pokok) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Tunjangan Hadir / Lainnya (Rp)</label>
                    <input type="number" name="tunjangan" class="form-control" min="0" step="1" value="{{ old('tunjangan', $salary->tunjangan) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Potongan (Rp)</label>
                    <input type="number" name="potongan" class="form-control" min="0" step="1" value="{{ old('potongan', $salary->potongan) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="status_pembayaran" class="form-control" required>
                        <option value="belum dibayar" {{ old('status_pembayaran', $salary->status_pembayaran) == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="sudah dibayar" {{ old('status_pembayaran', $salary->status_pembayaran) == 'sudah dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                    </select>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:20px;">
                    <a href="{{ route('admin.salaries.index', ['bulan_tahun' => $salary->bulan_tahun]) }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Penyesuaian</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
