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
            Content::where('exercise_id', $exercise->id)->get()->each(function ($content) {
                $content->delete();
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

    public function contents() {
        return $this->hasMany(Content::class);
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
