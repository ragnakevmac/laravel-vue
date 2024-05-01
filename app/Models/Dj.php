<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dj extends Model
{

    use HasFactory;

    protected $fillable = ['name'];

    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
