<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Album;

class SongFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(2),
            'album_id' => Album::inRandomOrder()->first()->id ?? Album::factory(), // ensure linked album
            'duration' => $this->faker->numberBetween(120, 400), // 2min–6min
        ];
    }
}
