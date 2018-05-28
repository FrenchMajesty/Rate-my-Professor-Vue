<?php

namespace App\Models\School;

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
        'slug',
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
     * Update the slug when saving the model
     * @return void 
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->slug = str_slug("$model->id $model->nick $model->name $model->location");
            $model->save();
        });

        static::saving(function ($model) {
            $model->slug = str_slug("$model->id $model->nick $model->name $model->location");
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
     * Get all the professors that work at this school
     * @return array 
     */
    public function professors()
    {
    	return $this->hasMany('\App\Models\Professor\Professor');
    }

    /**
     * Get all the departments of this school
     * @return array 
     */
    public function departments()
    {
        return $this->belongsToMany('\App\Models\School\Department','school_departments', 'school_id','department_id');
    }

    /**
     * Get the reviews that this school has received
     * @return array 
     */
    public function reviews()
    {
        return $this->hasMany('\App\Models\School\SchoolReview');
    }
}
