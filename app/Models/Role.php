<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function users() {
        return $this->hasMany(User::class);
    }
}
