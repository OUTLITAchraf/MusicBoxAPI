<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'genre' => $this->faker->randomElement(['Hip-Hop', 'Rock', 'Pop', 'Jazz', 'Classical', 'RAP']),
            'country' => $this->faker->country(),
        ];
    }
}

