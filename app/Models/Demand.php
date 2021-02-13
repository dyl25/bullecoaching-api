<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Demand extends Model
{
    protected $guarded = [];
    protected $appends = ['created_at_formated', 'age'];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    // Getters

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birthdate)->age;
    }

    public function getCreatedAtFormatedAttribute()
    {
        return $this->created_at->format('d-m-Y H:i');
    }

    //Scope

    public function scopeAccepted($query) {
        return $query->where('accepted', 1);
    }

    public function scopeRefused($query)
    {
        return $query->where('accepted', 0);
    }
}
