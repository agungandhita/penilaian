<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $query = Siswa::with('kelas');

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->integer('kelas_id'));
        }
        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($w) use ($q) {
                $w->where('nama_lengkap', 'like', "%$q%")
                  ->orWhere('nis', 'like', "%$q%");
            });
        }

        $siswa = $query->orderBy('nama_lengkap')->paginate(15)->withQueryString();
        return view('siswa.index', compact('siswa', 'kelasList'));
    }

    public function store(SiswaRequest $request): RedirectResponse
    {
        Siswa::create($request->validated());
        return back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function update(SiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $siswa->update($request->validated());
        return back()->with('success', 'Siswa berhasil diubah');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();
        return back()->with('success', 'Siswa berhasil dihapus');
    }
}

