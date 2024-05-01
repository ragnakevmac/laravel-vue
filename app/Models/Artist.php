<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function artist_songs()
    {
        return $this->hasMany(ArtistSong::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}