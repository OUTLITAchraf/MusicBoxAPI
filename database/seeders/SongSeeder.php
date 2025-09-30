<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Song;

class SongSeeder extends Seeder
{
    public function run(): void
    {
        // Create 100 songs
        Song::factory()->count(100)->create();
    }
}