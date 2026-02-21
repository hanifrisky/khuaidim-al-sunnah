<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@hafalan.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->call(KitabSeeder::class);
        $this->call(HaditsSeeder::class);
        $this->call(SoalPemahamanSeeder::class);
    }
}
