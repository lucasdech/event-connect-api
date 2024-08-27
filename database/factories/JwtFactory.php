<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JwtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unique_id' => Str::uuid()->toString(),
            'description' => fake()->sentence(),
            'permissions' => null, // Ou un tableau de permissions par défaut
            'expires_at' => now()->addWeeks(2), // Exemple de date d'expiration
            'last_used_at' => null, // Ou une date fictive si nécessaire
        ];
    }
}
