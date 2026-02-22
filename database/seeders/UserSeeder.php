<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use App\Models\Kitab;
use App\Models\Siswa;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@hafalan.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $guruUser =  User::factory()->create([
            'name' => 'Guru',
            'email' => 'guru@hafalan.id',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);
        $siswaUser = User::factory()->create([
            'name' => 'Siswa',
            'email' => 'siswa@hafalan.id',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        $guru = Guru::create([
            'user_id' => $guruUser->id,
            'name' => $guruUser->name,
            'jenis_kelamin' => 'laki-laki',
        ]);
        $kelas = Kelas::create([
            'guru_id' => $guru->id,
            'name' => 'Kelas',
        ]);
        $siswa = Siswa::create([
            'user_id' => $siswaUser->id,
            'name' => $siswaUser->name,
            'jenis_kelamin' => 'laki-laki',
            'kelas_id' => $kelas->id,
        ]);
    }
}
