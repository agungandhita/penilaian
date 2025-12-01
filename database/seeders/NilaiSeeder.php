<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = MataPelajaran::pluck('id');
        $siswa = Siswa::inRandomOrder()->get();
        $count = (int) ceil($siswa->count() * 0.5);
        $subset = $siswa->take($count);

        foreach ($subset as $s) {
            foreach ($mapel as $m) {
                $tugas = rand(60, 95);
                $uh = rand(60, 95);
                $uts = rand(60, 95);
                $uas = rand(60, 95);
                $na = ($tugas*0.2)+($uh*0.3)+($uts*0.2)+($uas*0.3);
                Nilai::updateOrCreate(
                    ['siswa_id' => $s->id, 'mapel_id' => $m],
                    [
                        'kelas_id' => $s->kelas_id,
                        'tugas' => $tugas,
                        'ulangan_harian' => $uh,
                        'uts' => $uts,
                        'uas' => $uas,
                        'nilai_akhir' => $na,
                    ]
                );
            }
        }
    }
}

