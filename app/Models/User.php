<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'fullname', 
        'age', 
        'created_at_formated',
        'isAdmin',
        'isCoach',
        'isUser',
        'hasPaid',
        'isExclude'
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    //Relations

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /*public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }*/

    public function createdExercises()
    {
        return $this->hasMany(Exercise::class, 'author_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_user');
    }

    public function createdPrograms()
    {
        return $this->hasMany(Program::class);
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class);
    }

    public function attachedEvents()
    {
        return $this->belongsToMany(Event::class)
            ->using(EventUser::class)
            ->withPivot('accepted');
    }

    // Getters

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birthdate)->age;
    }

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->name;
    }

    public function getCreatedAtFormatedAttribute()
    {
        return $this->created_at->format('d-m-Y H:i');
    }

    // Functions

    public function isAdmin(): bool
    {
        return $this->role->name ===  'admin' || $this->role->name ===  'super-admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role->name ===  'super-admin';
    }

    public function isAthlete(): bool
    {
        return $this->role->name === 'user' ||
            $this->role->name === 'admin' ||
            $this->role->name ===  'super-admin';
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function hasRole(string $role): bool
    {
        return $this->role->name === $role;
    }

    public function getIsAdminAttribute() {
        return $this->role->name ===  'admin' || $this->role->name ===  'super-admin';
    }

    public function getIsCoachAttribute()
    {
        return $this->role->name ===  'coach';
    }

    public function getIsUserAttribute()
    {
        return $this->role->name ===  'user';
    }

    public function getHasPaidAttribute()
    { 
        return $this->has_paid;
    }

    public function getIsExcludeAttribute() {
        return !$this->exclude;
    }

    //Get all the assigned exercises to a user
    public function assignedExercises()
    {
        return $this
            ->programs
            ->load('exercises', 'exercises.author')
            ->pluck('exercises')
            ->collapse()
            ->unique('id');
    }
}
