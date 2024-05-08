<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function artists()
    {
        // Define the relationship with Artist using belongsToMany and specify the pivot table
        return $this->belongsToMany(Artist::class, 'artist_song')
            ->withTimestamps(); // Add this if your pivot table includes timestamps
    }
}
