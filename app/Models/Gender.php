<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gender extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    //Relations

    public function users() {
        return $this->hasMany(User::class);
    }

}
