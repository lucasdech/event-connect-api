<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 20),
            'title' => fake()->word(),
            'is_private' => fake()->numberBetween(0, 1),
            'password' => static::$password ??= Hash::make('password'),
            'description' => fake()->paragraph(),
            'starting_at' => fake()->dateTime(),
            'location' => fake()->city(),   
        ];
    }
}
