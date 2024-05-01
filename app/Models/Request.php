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
        return $this->belongsTo(User::class);
    }

    public function djs()
    {
        return $this->belongsTo(Dj::class);
    }

    public function artist_songs()
    {
        return $this->belongsTo(ArtistSong::class);
    }
}
