<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistSong extends Model
{
    use HasFactory;

    protected $table = 'artist_song'; // Ensure it uses the correct table

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function songs()
    {
        return $this->belongsTo(Song::class, 'song_id'); // Make sure to specify foreign key if it's not standard
    }

    public function artists()
    {
        return $this->belongsTo(Artist::class, 'artist_id'); // Make sure to specify foreign key if it's not standard
    }
}
