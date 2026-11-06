<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::orderBy('nama_sekolah')->paginate(10);
        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('admin.schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'alamat'       => ['required', 'string'],
            'kuota_porsi'  => ['required', 'integer', 'min:0'],
            'foto'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama_sekolah.required' => 'Nama sekolah wajib diisi.',
            'alamat.required'       => 'Alamat wajib diisi.',
            'kuota_porsi.required'  => 'Kuota porsi wajib diisi.',
            'kuota_porsi.min'       => 'Kuota porsi tidak boleh negatif.',
            'foto.image'            => 'File foto harus berupa gambar.',
            'foto.mimes'            => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max'              => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('school', 'public');
        }

        School::create(array_merge($validated, ['foto_url' => $fotoPath]));

        return redirect()->route('admin.schools.index')
            ->with('success', 'Data sekolah mitra berhasil ditambahkan!');
    }

    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'alamat'       => ['required', 'string'],
            'kuota_porsi'  => ['required', 'integer', 'min:0'],
            'foto'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $fotoPath = $school->foto_url;

        if ($request->hasFile('foto')) {
            if ($school->foto_url && Storage::disk('public')->exists($school->foto_url)) {
                Storage::disk('public')->delete($school->foto_url);
            }
            $fotoPath = $request->file('foto')->store('school', 'public');
        }

        if ($request->boolean('hapus_foto') && $school->foto_url) {
            if (Storage::disk('public')->exists($school->foto_url)) {
                Storage::disk('public')->delete($school->foto_url);
            }
            $fotoPath = null;
        }

        $school->update(array_merge($validated, ['foto_url' => $fotoPath]));

        return redirect()->route('admin.schools.index')
            ->with('success', 'Data sekolah mitra berhasil diperbarui!');
    }

    public function destroy(School $school)
    {
        if ($school->foto_url && Storage::disk('public')->exists($school->foto_url)) {
            Storage::disk('public')->delete($school->foto_url);
        }

        $school->delete();

        return redirect()->route('admin.schools.index')
            ->with('success', 'Data sekolah mitra berhasil dihapus!');
    }
}
