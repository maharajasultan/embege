<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['chef', 'supir'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $chefs  = Staff::where('posisi', 'chef')->where('status_aktif', true)->get();
        $supirs = Staff::where('posisi', 'supir')->where('status_aktif', true)->get();

        return view('admin.menus.create', compact('chefs', 'supirs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'     => ['required', 'date'],
            'nama_menu'   => ['required', 'string', 'max:255'],
            'daftar_lauk' => ['nullable', 'array'],
            'daftar_lauk.*' => ['nullable', 'string', 'max:100'],
            'kalori'      => ['required', 'integer', 'min:0'],
            'karbohidrat' => ['required', 'integer', 'min:0'],
            'protein'     => ['required', 'integer', 'min:0'],
            'chef_id'     => ['nullable', 'exists:staffs,id'],
            'supir_id'    => ['nullable', 'exists:staffs,id'],
            'status'      => ['required', 'in:aktif,selesai,dibatalkan'],
            'foto'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'tanggal.required'   => 'Tanggal wajib diisi.',
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'kalori.required'    => 'Kalori wajib diisi.',
            'karbohidrat.required' => 'Karbohidrat wajib diisi.',
            'protein.required'   => 'Protein wajib diisi.',
            'foto.image'         => 'File foto harus berupa gambar.',
            'foto.mimes'         => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ]);

        // Filter lauk kosong
        $validated['daftar_lauk'] = array_filter($request->input('daftar_lauk', []), fn($l) => !empty(trim($l)));

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('menu', 'public');
        }

        Menu::create(array_merge($validated, ['foto_url' => $fotoPath]));

        return redirect()->route('admin.menus.index')
            ->with('success', 'Jadwal menu berhasil ditambahkan!');
    }

    public function show(Menu $menu)
    {
        $menu->load(['chef', 'supir']);
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $chefs  = Staff::where('posisi', 'chef')->where('status_aktif', true)->get();
        $supirs = Staff::where('posisi', 'supir')->where('status_aktif', true)->get();

        return view('admin.menus.edit', compact('menu', 'chefs', 'supirs'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'tanggal'     => ['required', 'date'],
            'nama_menu'   => ['required', 'string', 'max:255'],
            'daftar_lauk' => ['nullable', 'array'],
            'daftar_lauk.*' => ['nullable', 'string', 'max:100'],
            'kalori'      => ['required', 'integer', 'min:0'],
            'karbohidrat' => ['required', 'integer', 'min:0'],
            'protein'     => ['required', 'integer', 'min:0'],
            'chef_id'     => ['nullable', 'exists:staffs,id'],
            'supir_id'    => ['nullable', 'exists:staffs,id'],
            'status'      => ['required', 'in:aktif,selesai,dibatalkan'],
            'foto'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['daftar_lauk'] = array_filter($request->input('daftar_lauk', []), fn($l) => !empty(trim($l)));

        $fotoPath = $menu->foto_url;

        if ($request->hasFile('foto')) {
            if ($menu->foto_url && Storage::disk('public')->exists($menu->foto_url)) {
                Storage::disk('public')->delete($menu->foto_url);
            }
            $fotoPath = $request->file('foto')->store('menu', 'public');
        }

        if ($request->boolean('hapus_foto') && $menu->foto_url) {
            if (Storage::disk('public')->exists($menu->foto_url)) {
                Storage::disk('public')->delete($menu->foto_url);
            }
            $fotoPath = null;
        }

        $menu->update(array_merge($validated, ['foto_url' => $fotoPath]));

        return redirect()->route('admin.menus.index')
            ->with('success', 'Jadwal menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->foto_url && Storage::disk('public')->exists($menu->foto_url)) {
            Storage::disk('public')->delete($menu->foto_url);
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Jadwal menu berhasil dihapus!');
    }
}
