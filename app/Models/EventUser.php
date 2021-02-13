<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUser extends Pivot
{
    const UPDATED_AT = 'accepted_at';

    protected $tabe = 'event_user';
    protected $dates = ['accepted_at'];

    public $timestamps = false;

}
