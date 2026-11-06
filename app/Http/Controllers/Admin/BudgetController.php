<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::orderBy('tanggal', 'desc')->paginate(15);
        
        $summary = [
            'total_pemasukan'   => Budget::where('jenis', 'pemasukan')->sum('nominal'),
            'total_pengeluaran' => Budget::where('jenis', 'pengeluaran')->sum('nominal'),
        ];
        $summary['saldo'] = $summary['total_pemasukan'] - $summary['total_pengeluaran'];

        return view('admin.budgets.index', compact('budgets', 'summary'));
    }

    public function create()
    {
        return view('admin.budgets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => ['required', 'date'],
            'jenis'      => ['required', 'in:pemasukan,pengeluaran'],
            'kategori'   => ['required', 'string', 'max:255'],
            'nominal'    => ['required', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Budget::create($validated);

        return redirect()->route('admin.budgets.index')
            ->with('success', 'Data anggaran berhasil ditambahkan!');
    }

    public function edit(Budget $budget)
    {
        return view('admin.budgets.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'tanggal'    => ['required', 'date'],
            'jenis'      => ['required', 'in:pemasukan,pengeluaran'],
            'kategori'   => ['required', 'string', 'max:255'],
            'nominal'    => ['required', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $budget->update($validated);

        return redirect()->route('admin.budgets.index')
            ->with('success', 'Data anggaran berhasil diperbarui!');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();

        return redirect()->route('admin.budgets.index')
            ->with('success', 'Data anggaran berhasil dihapus!');
    }
}
