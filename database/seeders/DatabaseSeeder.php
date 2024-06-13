<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dj;
use App\Models\Artist;
use App\Models\Song;
use App\Models\ArtistSong;
use App\Models\Request;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

#NOTE solved the bug for POST but there's still a bug for UPDATE

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(ArtistSeeder::class);
        $this->call(SongSeeder::class);
        $this->call(ArtistSongSeeder::class);
    }
}