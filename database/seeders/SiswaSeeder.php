<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = Kelas::orderBy('id')->get();
        $nisStart = 2024001;
        foreach ($kelas as $k) {
            for ($i = 0; $i < 10; $i++) {
                $nis = (string)($nisStart + $i);
                $nama = 'Siswa ' . $k->nama_kelas . ' ' . ($i+1);
                Siswa::firstOrCreate([
                    'nis' => $nis,
                ], [
                    'nama_lengkap' => $nama,
                    'kelas_id' => $k->id,
                ]);
            }
            $nisStart += 10;
        }
    }
}

