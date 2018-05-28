<?php

namespace App\Models\Professor;

use Illuminate\Database\Eloquent\Model;

class ReviewFeedback extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'professor_review_feedbacks';

	/**
	 * The attributes that are mass assignable
	 * @var array
	 */
    protected $fillable = [
    	'review_id',
    	'ip_address',
    	'positive',
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
   		'positive' => 'boolean',
   	];

   	/**
     * Update the IP address when saving the model
     * @return void 
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ip_address = $_SERVER['REMOTE_ADDR'];
        });
    }
}
