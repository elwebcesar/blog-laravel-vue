<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Andy Dev',
            'email' => 'andy@dev.com',
            'password' => Hash::make('holamundo'),
            'path' => 'files/user1/'
        ]);

        User::factory()->create([
            'name' => 'Juan Wick',
            'email' => 'wick@dev.com',
            'password' => Hash::make('holamundo'),
            'path' => 'files/user2/'
        ]);

        User::factory()->create([
            'name' => 'John Wick',
            'email' => 'john@dev.com',
            'password' => Hash::make('holamundo'),
            'path' => 'files/user3/'
        ]);

        $this->call([
            ModuleSeeder::class,
            PermitSeeder::class,
            PostSeeder::class,
        ]);
    }
}
