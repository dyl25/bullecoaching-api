<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Exercise extends Model
{
    protected $guarded = [];
    protected $with = ['contents', 'difficulty', 'tags'];
    protected $appends = ['created_at_formated', 'updated_at_formated', 'featuredImage'];

    protected static function boot() {
        parent::boot();

        static::deleting(function(Exercise $exercise) {

            /*
             * il faut obtenir des instances Eloquent afin de trigger l'event 
             * de suppression sur le model Content
             */
            Media::where('exercise_id', $exercise->id)->get()->each(function ($media) {
                $media->delete();
            });
        });

    }

    //Relations

    public function programs(){
        return $this->belongsToMany(Program::class, 'exercise_program');
    }

    public function difficulty() {
        return $this->belongsTo(Difficulty::class);
    }

    public function medias() {
        return $this->hasMany(Media::class);
    }

    public function beginImage()
    {
        return $this->hasOne(Media::class, 'begin_image_id');
    }

    public function endImage()
    {
        return $this->hasOne(Media::class, 'end_image_id');
    }

    public function video() {
        return $this->hasOne(Media::class);
    }

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    // Getters

    public function getCreatedAtFormatedAttribute() {
        return $this->created_at->format('d-m-Y H:i');
    }

    public function getUpdatedAtFormatedAttribute() {
        return $this->updated_at->format('d-m-Y H:i');
    }

    public function getFeaturedImageAttribute() {
        if($this->isImage()) {
            return $this->contents->first()->filename;
        }

        return null;
    }

    public function getFeaturedExplenationAttribute() {
        if($this->isImage() || $this->isText()) {
            if($this->contents->first()) {
                return Str::limit($this->contents->first()->explenation, 150);
            } 
        }

        return null;
    }

    //Mutators

    public function isImage(): bool {
        return $this->display_mode === 'image';
    }

    public function isVideo(): bool {
        return $this->display_mode === 'video';
    }

    public function isText(): bool{
        return $this->display_mode === 'text';
    }

}
