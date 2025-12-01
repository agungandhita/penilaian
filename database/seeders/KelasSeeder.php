<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $data = ['10 IPA 1','11 IPA 1','12 IPA 1'];
        foreach ($data as $nama) {
            Kelas::firstOrCreate(['nama_kelas' => $nama]);
        }
    }
}

