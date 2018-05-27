<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

	/**
	 * The attributes that are mass assignable
	 * @var array
	 */
    protected $fillable = [
        'name',
        'slug',
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
     * Update the slug when saving the model
     * @return void 
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = $model->id.'-'.str_slug($model->name);
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
}
