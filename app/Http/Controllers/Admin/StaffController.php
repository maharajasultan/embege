<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::orderBy('posisi')->orderBy('nama_lengkap')->paginate(12);
        return view('admin.staffs.index', compact('staffs'));
    }

    public function create()
    {
        return view('admin.staffs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'posisi'       => ['required', 'in:chef,supir,admin,manajer,staf'],
            'status_aktif' => ['boolean'],
            'foto'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'posisi.required'       => 'Posisi/jabatan wajib dipilih.',
            'foto.image'            => 'File foto harus berupa gambar.',
            'foto.mimes'            => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max'              => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('staff', 'public');
        }

        Staff::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'posisi'       => $validated['posisi'],
            'status_aktif' => $request->boolean('status_aktif', true),
            'foto_url'     => $fotoPath,
        ]);

        return redirect()->route('admin.staffs.index')
            ->with('success', 'Data staf berhasil ditambahkan!');
    }

    public function show(Staff $staff)
    {
        return view('admin.staffs.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        return view('admin.staffs.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'posisi'       => ['required', 'in:chef,supir,admin,manajer,staf'],
            'status_aktif' => ['boolean'],
            'foto'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'posisi.required'       => 'Posisi/jabatan wajib dipilih.',
            'foto.image'            => 'File foto harus berupa gambar.',
            'foto.mimes'            => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max'              => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = $staff->foto_url;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($staff->foto_url && Storage::disk('public')->exists($staff->foto_url)) {
                Storage::disk('public')->delete($staff->foto_url);
            }
            $fotoPath = $request->file('foto')->store('staff', 'public');
        }

        // Hapus foto jika diminta
        if ($request->boolean('hapus_foto') && $staff->foto_url) {
            if (Storage::disk('public')->exists($staff->foto_url)) {
                Storage::disk('public')->delete($staff->foto_url);
            }
            $fotoPath = null;
        }

        $staff->update([
            'nama_lengkap' => $validated['nama_lengkap'],
            'posisi'       => $validated['posisi'],
            'status_aktif' => $request->boolean('status_aktif'),
            'foto_url'     => $fotoPath,
        ]);

        return redirect()->route('admin.staffs.index')
            ->with('success', 'Data staf berhasil diperbarui!');
    }

    public function destroy(Staff $staff)
    {
        // Hapus foto dari storage
        if ($staff->foto_url && Storage::disk('public')->exists($staff->foto_url)) {
            Storage::disk('public')->delete($staff->foto_url);
        }

        $staff->delete();

        return redirect()->route('admin.staffs.index')
            ->with('success', 'Data staf berhasil dihapus!');
    }
}
