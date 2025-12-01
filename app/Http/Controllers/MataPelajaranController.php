<?php

namespace App\Http\Controllers;

use App\Http\Requests\MataPelajaranRequest;
use App\Models\MataPelajaran;
use Illuminate\Http\RedirectResponse;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::orderBy('nama_mapel')->paginate(15);
        return view('mata-pelajaran.index', compact('mapel'));
    }

    public function store(MataPelajaranRequest $request): RedirectResponse
    {
        MataPelajaran::create($request->validated());
        return back()->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    public function update(MataPelajaranRequest $request, MataPelajaran $mata_pelajaran): RedirectResponse
    {
        $mata_pelajaran->update($request->validated());
        return back()->with('success', 'Mata pelajaran berhasil diubah');
    }

    public function destroy(MataPelajaran $mata_pelajaran): RedirectResponse
    {
        $mata_pelajaran->delete();
        return back()->with('success', 'Mata pelajaran berhasil dihapus');
    }
}

