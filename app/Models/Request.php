<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'comment'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function djs()
    {
        return $this->belongsTo(Dj::class, 'dj_id');
    }

    public function artist_song()
    {
        return $this->belongsTo(ArtistSong::class, 'artist_song_id');
    }
}
