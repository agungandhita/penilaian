<?php

namespace App\Http\Controllers;

use App\Http\Requests\NilaiBulkRequest;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function input(Request $request)
    {
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $mapelList = MataPelajaran::orderBy('nama_mapel')->get();
        $selectedKelas = $request->integer('kelas_id');
        $selectedMapel = $request->integer('mapel_id');

        $items = collect();
        if ($selectedKelas && $selectedMapel) {
            $siswa = Siswa::where('kelas_id', $selectedKelas)->orderBy('nama_lengkap')->get();
            $existing = Nilai::whereIn('siswa_id', $siswa->pluck('id'))
                ->where('mapel_id', $selectedMapel)
                ->get()
                ->keyBy('siswa_id');

            $items = $siswa->map(function ($row) use ($existing) {
                $n = $existing->get($row->id);
                return [
                    'siswa' => $row,
                    'nilai' => $n,
                ];
            });
        }

        return view('nilai.input', compact('kelasList', 'mapelList', 'selectedKelas', 'selectedMapel', 'items'));
    }

    public function save(NilaiBulkRequest $request)
    {
        $kelasId = $request->integer('kelas_id');
        $mapelId = $request->integer('mapel_id');
        $items = $request->input('items', []);

        DB::transaction(function () use ($items, $kelasId, $mapelId) {
            foreach ($items as $item) {
                $tugas = $item['tugas'] ?? null;
                $uh = $item['ulangan_harian'] ?? null;
                $uts = $item['uts'] ?? null;
                $uas = $item['uas'] ?? null;

                $nilaiAkhir = null;
                if ($tugas !== null || $uh !== null || $uts !== null || $uas !== null) {
                    $nilaiAkhir = (
                        (float)($tugas ?? 0) * 0.20 +
                        (float)($uh ?? 0) * 0.30 +
                        (float)($uts ?? 0) * 0.20 +
                        (float)($uas ?? 0) * 0.30
                    );
                }

                Nilai::updateOrCreate(
                    ['siswa_id' => $item['siswa_id'], 'mapel_id' => $mapelId],
                    [
                        'kelas_id' => $kelasId,
                        'tugas' => $tugas,
                        'ulangan_harian' => $uh,
                        'uts' => $uts,
                        'uas' => $uas,
                        'nilai_akhir' => $nilaiAkhir,
                    ]
                );
            }
        });

        return back()->with('success', 'Nilai berhasil disimpan');
    }
}

