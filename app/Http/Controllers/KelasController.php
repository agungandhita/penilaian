<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelasRequest;
use App\Models\Kelas;
use Illuminate\Http\RedirectResponse;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->orderBy('nama_kelas')->paginate(15);
        return view('kelas.index', compact('kelas'));
    }

    public function store(KelasRequest $request): RedirectResponse
    {
        Kelas::create($request->validated());
        return back()->with('success', 'Kelas berhasil ditambahkan');
    }

    public function update(KelasRequest $request, Kelas $kelas): RedirectResponse
    {
        $kelas->update($request->validated());
        return back()->with('success', 'Kelas berhasil diubah');
    }

    public function destroy(Kelas $kelas): RedirectResponse
    {
        $kelas->delete();
        return back()->with('success', 'Kelas berhasil dihapus');
    }
}

