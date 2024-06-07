<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtistSongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve all artists
        $artists = DB::table('artists')->get();

        foreach ($artists as $artist) {
            // Retrieve all songs for the current artist
            $songs = DB::table('songs')->where('artist_id', $artist->id)->get();

            foreach ($songs as $song) {
                // Insert a record into the artist_song table
                DB::table('artist_song')->insert([
                    'artist_id' => $artist->id,
                    'song_id' => $song->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}