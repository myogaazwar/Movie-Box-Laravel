<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    protected $fillable = [
        'user_id',
        'poster_path',
        'title',
        'type',
        'release_date',
        'imdb_id',
    ];
}
