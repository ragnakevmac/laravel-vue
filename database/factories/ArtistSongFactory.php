<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Song;
use App\Models\Artist;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArtistSong>
 */
class ArtistSongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'song_id' => Song::query()->inRandomOrder()->first()->id,
            'artist_id' => Artist::query()->inRandomOrder()->first()->id
        ];
    }
}
