<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 20 fake artists
        Artist::factory()->count(10)->create();
    }
}
