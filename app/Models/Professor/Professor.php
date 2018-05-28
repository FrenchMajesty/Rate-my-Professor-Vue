<?php

namespace App\Models\Professor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professor extends Model
{	
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable
	 * @var array
	 */
    protected $fillable = [
    	'firstname',
    	'lastname',
        'slug',
    	'school_id',
    	'department_id',
    	'directory_url',
    	'approved',
   	];

   	/**
   	 * The attributes that should be mutated to dates
   	 * @var array
   	 */
   	protected $dates = [
   		'created_at',
   		'updated_at',
   		'deleted_at',
   	];

   	/**
   	 * The attributes that should be mutated to native types
   	 * @var array
   	 */
   	protected $casts = [
   		'approved' => 'boolean',
   	];

    /**
     * The attributes to append to a JSON response
     * @var array
     */
    protected $appends = ['name'];

    /**
     * Update the slug when saving and creating the model
     * @return void 
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->slug = str_slug("$model->id $model->firstname $model->lastname");
            $model->save();
        });

        static::saving(function ($model) {
            $model->slug = str_slug("$model->id $model->firstname $model->lastname");
        });
    }

    /**
     * Change the column with which to bind the model route
     * @return string 
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

   	/**
   	 * Get the full name of the professor
   	 * @return string 
   	 */
   	public function getNameAttribute()
   	{
   		return $this->firstname . ' ' . $this->lastname;
   	}

    /**
     * Get the school where this professor teaches
     * @return \App\Models\School\School
     */
    public function school()
    {
        return $this->belongsTo('\App\Models\School\School'); 
    }

    /**
     * Get the department where this professor teaches
     * @return \App\Models\School\Department 
     */
    public function department()
    {
        return $this->belongsTo('\App\Models\School\Department');
    }

    /**
     * Get the reviews that this professor has received
     * @return array 
     */
    public function reviews()
    {
     	return $this->hasMany('\App\Models\Professor\ProfessorReview');
    }
}
