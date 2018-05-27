<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'account',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes to append to a JSON response
     * @var array
     */
    protected $appends = ['name'];

    /**
     * Return the full name of the user
     * @return string 
     */
    public function getNameAttribute()
    {
        return $this->firstname.' '.$this->lastname;
    }

    /**
     * Get the admin model of this user
     * @return \App\Models\Account\Admin 
     */
    public function admin()
    {
        return $this->hasOne('App\Models\Account\Admin');
    }

    /**
     * Get the student model of this user
     * @return \App\Models\Account\Student 
     */
    public function student()
    {
        return $this->hasOne('App\Models\Account\Student');
    }
}
