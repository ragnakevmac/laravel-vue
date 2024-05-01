<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function artist_songs()
    {
        return $this->hasMany(ArtistSong::class);
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }
}
