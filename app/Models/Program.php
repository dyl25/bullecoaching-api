<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Program extends Model
{
    protected $guarded = [];
    protected $appends = ['created_at_formated', 'updated_at_formated'];
    //protected $with = ['exercises'];

    //Relations

    public function exercises() {
        return $this->belongsToMany(Exercise::class, 'exercise_program');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'program_user');
    }

    public function difficulty() {
        return $this->belongsTo(Difficulty::class);
    }

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function attachedEvents() {
        return $this->hasMany(Event::class);
    }

    // Getters

    public function getCreatedAtFormatedAttribute()
    {
        return $this->created_at->format('d-m-Y H:i');
    }

    public function getUpdatedAtFormatedAttribute()
    {
        return $this->updated_at->format('d-m-Y H:i');
    }

    //Scopes

    /*
     * Filter programs by name
     *
     * @param Builder $query
     * @param string $name The name of the program
     * @return Builder
     */
    public function scopeFilterName(Builder $query, string $name): Builder {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function scopeFilterTags(Builder $query, string $tag): Builder {
        return $query->whereHas('exercises.tags', function ($query) use ($tag) {
            $query->where('tags.slug', $tag);
        });
    }

    public static function associated(User $user): Builder {
        return static::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->where('private', 1);
    }

    //Helper

    public function isPrivate() {
        return $this->private == 1;
    }

    /*
     * Get tag associated with program
     *
     * @return void
     */
    public function exercisesTag() {
        /*$exercisesId = $this->exercises->pluck('id');

        return Tag::whereHas('exercises', function($query) use($exercisesId) {
            $query->whereIn('exercise_id', $exercisesId);
        })
        ->get();*/

        return $this->exercises->pluck('tags')->flatten()->unique('id');

    }

}
