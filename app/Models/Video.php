<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Video $video) {
            unlink(storage_path('app/exercises/video/' . $video->filename));
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
        return storage_path('exercises/video/' . $this->filename);
    }
}
