<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistSong extends Model
{
    use HasFactory;

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function songs()
    {
        return $this->belongsTo(Song::class);
    }

    public function artists()
    {
        return $this->belongsTo(Artist::class);
    }
}
