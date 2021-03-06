<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function exercises() {
        return $this->belongsToMany(Exercise::class);
    }
}
