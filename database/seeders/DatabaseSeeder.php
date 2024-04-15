<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $level = Level::factory()->create([
            'nama_level' => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'level_id' => $level->id,
            'username' => 'admin',
            'password' => Hash::make('password'),
            'nama' => "Admin",
            'jenis_kelamin' => 'l',
            'alamat' => 'Jl. Sunggal',
            'email' => 'admin@gmail.com',
            'no_telepon' => '0812300123',
            'status' => 'active'
        ]);
    }
}
