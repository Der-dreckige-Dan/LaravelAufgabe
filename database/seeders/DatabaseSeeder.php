<?php

namespace Database\Seeders;

use App\Models\Aufgabe;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        User::factory()->create(['email'=>'test','password' => '1234']);
        Aufgabe::factory(10)->create();
    }
}
