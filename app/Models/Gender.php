<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    //Relations

    public function users() {
        return $this->hasMany(User::class);
    }

}
