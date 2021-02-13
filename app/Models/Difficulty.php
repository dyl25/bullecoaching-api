<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Difficulty extends Model
{
    protected $guarded = [];

    public function exercises() {
        return $this->hasMany(Exercise::class);
    }

    public function programs() {
        return $this->hasMany(Program::class);
    }
}
