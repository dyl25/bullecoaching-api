<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];
    protected $appends = ['storagePath'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Media $media) {
            if ($media->isImage()) {
                unlink(storage_path('app/exercises/img/' . $media->filename));
            } elseif ($media->isVideo()) {
                unlink(storage_path('app/exercises/video/' . $media->filename));
            }
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
        if ($this->isVideo()) {
            return storage_path('exercises/img/' . $this->filename);
        } elseif ($this->isImage()) {
            return storage_path('exercises/video/' . $this->filename);
        }
    }

    //Utility

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }
}
