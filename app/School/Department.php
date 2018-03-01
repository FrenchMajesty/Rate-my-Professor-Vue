<?php

namespace App\School;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	/**
	 * The attributes that are mass assignable
	 * @var array
	 */
    protected $fillable = ['name'];

    /**
     * The attributes that should be mutated to dates
     * @var array
     */
    protected $dates = [
    	'created_at',
    	'updated_at',
    ];
}
