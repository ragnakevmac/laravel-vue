<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArtistSongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $jsonPath = database_path('data/kpop_song_artist.json');
        $jsonData = File::get($jsonPath);
        $data = json_decode($jsonData, true);

        foreach ($data as $artist) {
            $artistId = DB::table('artists')->where('spotify_id', $artist['artist_id'])->value('id');

            if ($artistId) {
                foreach ($artist['songs'] as $song) {
                    $songId = DB::table('songs')->where('spotify_id', $song['song_id'])->value('id');

                    if ($songId) {
                        DB::table('artist_song')->insert([
                            'artist_id' => $artistId,
                            'song_id' => $songId,
                        ]);
                    }
                }
            }
        }
    }
}