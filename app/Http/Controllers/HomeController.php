<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function cekNilai(Request $request)
    {
        $q = trim($request->string('q'));
        $siswa = null;
        if ($q !== '') {
            $siswa = Siswa::with('kelas')
                ->where('nis', 'like', "%$q%")
                ->orWhere('nama_lengkap', 'like', "%$q%")
                ->first();
        }
        $mapelList = MataPelajaran::orderBy('nama_mapel')->get();
        $selectedMapel = $request->integer('mapel_id');
        $nilai = null;
        if ($siswa && $selectedMapel) {
            $nilai = Nilai::where('siswa_id', $siswa->id)->where('mapel_id', $selectedMapel)->first();
        }
        return view('home.cek-nilai', compact('siswa', 'mapelList', 'selectedMapel', 'nilai', 'q'));
    }

    public function cetakTranskrip(Request $request)
    {
        $siswaId = $request->integer('siswa_id');
        $siswa = Siswa::with('kelas')->findOrFail($siswaId);
        $semuaNilai = Nilai::with('mataPelajaran')->where('siswa_id', $siswaId)->orderBy('mapel_id')->get();
        $pdf = Pdf::loadView('pdf.transkrip', compact('siswa', 'semuaNilai'));
        return $pdf->download('transkrip_' . $siswa->nis . '.pdf');
    }
}

