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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(ArtistSeeder::class);


        User::factory(10)->create();
        Dj::factory(5)->create();
        // Artist::factory(30)->create();
        Song::factory(100)->create();
        ArtistSong::factory(15)->create();
        Request::factory(15)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
