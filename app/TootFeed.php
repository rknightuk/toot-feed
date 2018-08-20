<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TootFeed extends Model
{
    protected $table = 'feeds';

    protected $fillable = ['url', 'output', 'latest'];

    public $timestamps = false;
}
