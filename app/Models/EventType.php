<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    public $timestamps = false;

    protected $table = 'events_type';
    protected $guarded = [];

    //Relations

    public function events() {
        return $this->hasMany(Event::class);
    }

}
