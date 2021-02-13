<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];
    protected $dates = [
        'from',
        'to'
    ];
    protected $appends = ['from_formated', 'to_formated','created_at_formated', 'updated_at_formated'];

    //Relations

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function content()
    {
        return $this->belongsTo(Program::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(EventUser::class)
            ->withPivot(['accepted', 'accepted_at']);
    }

    public function setToAttribute($value)
    {
        if (!is_null($value)) {
            $this->attributes['to'] = date("Y-m-d H:i:s", strtotime($value));
        } else {
            $this->attributes['to'] = $this->attributes['from'];
        }
    }

    public function isOneDayEvent(): bool
    {
        return is_null($this->to) || $this->from->format('Y-m-d') == $this->to->format('Y-m-d');
    }

    public function isType(string $type): bool
    {
        return $this->eventType->name === $type;
    }

    public function scopeActual($query)
    {
        return $query->where('to', '>=', date('Y-m-d h:i:s'));
    }

    // Getters
    public function getFromFormatedAttribute()
    {
        return $this->from->format('d-m-Y H:i');
    }

    public function getToFormatedAttribute()
    {
        return $this->to->format('d-m-Y H:i');
    }

    public function getCreatedAtFormatedAttribute()
    {
        return $this->created_at->format('d-m-Y H:i');
    }

    public function getUpdatedAtFormatedAttribute()
    {
        return $this->updated_at->format('d-m-Y H:i');
    }
}
