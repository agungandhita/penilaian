<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_mapel' => 'MTK001', 'nama_mapel' => 'Matematika'],
            ['kode_mapel' => 'FIS001', 'nama_mapel' => 'Fisika'],
            ['kode_mapel' => 'KIM001', 'nama_mapel' => 'Kimia'],
            ['kode_mapel' => 'BIO001', 'nama_mapel' => 'Biologi'],
            ['kode_mapel' => 'ING001', 'nama_mapel' => 'Bahasa Inggris'],
        ];
        foreach ($data as $row) {
            MataPelajaran::firstOrCreate(['kode_mapel' => $row['kode_mapel']], $row);
        }
    }
}

