<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Artist;

class AlbumFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'artist_id' => Artist::inRandomOrder()->first()->id ?? Artist::factory(), // ensure linked artist
            'genre' => $this->faker->randomElement(['Hip-Hop', 'Rock', 'Pop', 'Jazz', 'Classical']),
            'release_date' => $this->faker->date(),
        ];
    }
}
