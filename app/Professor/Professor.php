<?php

namespace App\Professor;

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
   	 * Get the full name of the professor
   	 * @return string 
   	 */
   	public function getNameAttribute()
   	{
   		return $this->firstname . ' ' . $this->lastname;
   	}

    /**
     * Get the school where this professor teaches
     * @return \App\School\School
     */
    public function school()
    {
        return $this->belongsTo('\App\School\School'); 
    }
}
