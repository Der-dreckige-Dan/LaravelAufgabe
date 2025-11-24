<?php

namespace Database\Factories;

use App\Enums\AufgabenStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AufgabeFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'title' => fake()->words(4, true),
            'description' => fake()->sentences(3, true),
            'status' => fake()->randomElement(AufgabenStatus::cases()),
        ];
    }
}
