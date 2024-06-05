<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to the JSON file
        $json = File::get(database_path('data/kpop_song_artist.json'));

        // Decode JSON data into an array
        $data = json_decode($json, true);

        // Extract unique group or stage names
        $artistsData = collect($data)->map(function ($idol) {
            return [
                'artist_name' => $idol['artist_name'],
                'artist_id' => $idol['artist_id'],
                'popularity' => $idol['popularity'],
                'songs' => $idol['songs']
            ];
        })->unique('artist_name');

        // Insert each artist and their details into the artists table
        foreach ($artistsData as $artist) {
            DB::table('artists')->insert([
                'name' => $artist['artist_name'],
                'popularity' => $artist['popularity'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Insert each song for the current artist into the songs table
            foreach ($artist['songs'] as $song) {
                DB::table('songs')->insert([
                    'artist_id' => $artist['artist_id'], // Assuming there's a foreign key to the artists table
                    'song_name' => $song['song_name'],
                    'song_id' => $song['song_id'],
                    'popularity' => $song['popularity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Insert video links if needed
                foreach ($song['video_links'] as $video_link) {
                    DB::table('video_links')->insert([
                        'song_id' => $song['song_id'],
                        'link' => $video_link,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                // Insert collaboration artists if needed
                foreach ($song['collaboration_artists'] as $collab_artist) {
                    DB::table('collaboration_artists')->insert([
                        'song_id' => $song['song_id'],
                        'artist_name' => $collab_artist,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }
}