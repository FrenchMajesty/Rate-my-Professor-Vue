<?php

namespace App\School;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{	
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable
	 * @var array
	 */
    protected $fillable = [
    	'name',
    	'nickname',
    	'location',
    	'website',
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
     * Get all the professors that attend this school
     * @return array 
     */
    public function professors()
    {
    	return $this->hasMany('\App\Professor\Professor');
    }
}
