<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'guru'],
            [
                'nama_lengkap' => 'Bapak Guru',
                'name' => 'Bapak Guru',
                'email' => 'guru@example.com',
                'password' => Hash::make('guru123'),
            ]
        );
    }
}
