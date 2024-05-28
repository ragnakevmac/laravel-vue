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
        $json = File::get(database_path('data/kpop_idols.json'));

        // Decode JSON data into an array
        $data = json_decode($json, true);

        // Extract unique group or stage names
        $names = collect($data)->map(function ($idol) {
            return $idol['Group'] ?: $idol['Stage Name'];
        })->unique();

        // Insert each name into the artists table
        foreach ($names as $name) {
            DB::table('artists')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
