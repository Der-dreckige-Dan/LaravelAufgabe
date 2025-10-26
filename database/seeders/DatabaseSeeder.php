<?php

namespace Database\Seeders;

use App\Models\Aufgabe;
use App\Models\Benutzer;
use App\Models\Projekt;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        User::factory()->create(['email' => 'test', 'password' => '1234']);
        User::factory(10)->create();
        Projekt::factory(10)->create();
        Aufgabe::factory(10)->create();
    }
}
