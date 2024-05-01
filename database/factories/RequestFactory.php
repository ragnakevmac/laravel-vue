<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Dj;
use App\Models\ArtistSong;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // By default, this will create a new User, DJ, and ArtistSong each time a Request is created
        return [
            'status' => 'pending', // Default status
            'comment' => $this->faker->text(200), // Random comment using Faker
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'dj_id' => Dj::query()->inRandomOrder()->first()->id,
            'artist_song_id' => ArtistSong::query()->inRandomOrder()->first()->id
        ];
    }
}
