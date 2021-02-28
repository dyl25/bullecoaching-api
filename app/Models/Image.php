<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Image $image) {
            unlink(storage_path('app/exercises/img/' . $image->filename));
        });
    }

    //Relations

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    //Mutators

    public function getStoragePathAttribute()
    {
        return storage_path('exercises/img/' . $this->filename);
    }
}
