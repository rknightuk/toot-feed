<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string url
 * @property string output
 * @property string|null latest
 */

class TootFeed extends Model
{
    protected $table = 'feeds';

    protected $fillable = ['url', 'output', 'latest'];

    public $timestamps = false;

    public function getUrl()
    {
        return $this->url;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getLatest()
    {
        return $this->latest;
    }

    public function setLatest($guid)
    {
        $this->latest = $guid;
    }
}
