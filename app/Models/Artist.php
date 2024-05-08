<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function songs()
    {
        // Define the relationship with Song using belongsToMany and specify the pivot table
        return $this->belongsToMany(Song::class, 'artist_song')
            ->withTimestamps(); // Add this if your pivot table includes timestamps
    }
}
