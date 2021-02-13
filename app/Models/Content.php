<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    protected $guarded = [];
    protected $appends = ['storagePath'];

    protected static function boot() {
        parent::boot();

        static::deleting(function(Content $content) {
            if($content->isImage()) {
                unlink(storage_path('app/exercises/img/' . $content->filename));
            }elseif($content->isVideo()) {
                unlink(storage_path('app/exercises/video/' . $content->filename));
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

    public function isText(): bool
    {
        return $this->type === 'text';
    }
}
