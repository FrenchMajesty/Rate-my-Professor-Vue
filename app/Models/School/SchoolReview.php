<?php

namespace App\Models\School;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolReview extends Model
{
	use SoftDeletes;

    /**
	 * The attributes that are mass assignable
	 * @var array
	 */
    protected $fillable = [
    	'school_id',
    	'user_id',
    	'overall_rating',
    	'location_rating',
    	'facilities_rating',
    	'opportunity_rating',
    	'social_rating',
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
     * Shorten the `overall_rating` attribute to 1 digital place
     * @param  string $value The value of the column
     * @return string        
     */
    public function getOverallRatingAttribute($value)
    {
    	return number_format($value, 1);
    }

    /**
     * Shorten the `location_rating` attribute to 1 digital place
     * @param  string $value The value of the column
     * @return string        
     */
    public function getLocationRatingAttribute($value)
    {
    	return number_format($value, 1);
    }

    /**
     * Shorten the `facilities_rating` attribute to 1 digital place
     * @param  string $value The value of the column
     * @return string        
     */
    public function getFacilitiesRatingAttribute($value)
    {
    	return number_format($value, 1);
    }

    /**
     * Shorten the `opportunity_rating` attribute to 1 digital place
     * @param  string $value The value of the column
     * @return string        
     */
    public function getOpportunityRatingAttribute($value)
    {
    	return number_format($value, 1);
    }

    /**
     * Shorten the `social_rating` attribute to 1 digital place
     * @param  string $value The value of the column
     * @return string        
     */
    public function getSocialRatingAttribute($value)
    {
    	return number_format($value, 1);
    }

    /**
     * Get all of the feedback that this review has
     * @return array 
     */
    public function feedback()
    {
        return $this->hasMany('\App\Models\School\ReviewFeedback','review_id');
    }

    /**
     * Get the school to whom this review belongs to
     * @return School 
     */
    public function school()
    {
    	return $this->belongsTo('\App\Models\School\School');
    }

    /**
     * Get the student that posted this review
     * @return User 
     */
    public function student()
    {
    	return $this->belongsTo('App\User');
    }
}
