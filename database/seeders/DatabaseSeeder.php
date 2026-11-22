<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Rina',
            'email' => 'rina@example.com',
        ]);

        User::factory()->create([
            'name'  => 'Budi',
            'email' => 'budi@example.com',
        ]);

        $this->call(MediaSeeder::class);
    }
}
