<?php

namespace App\Models\Professor;

use Illuminate\Database\Eloquent\Model;

class ProfessorReview extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'professor_id',
    	'user_id',
        'overall_rating',
        'difficulty_rating',
        'textbook_used',
        'would_retake',
        'comment',
        'grade_received',
        'class',
        'approved',
    ];

    /**
     * The attributes that should be mutated to native types
     * @var array
     */
    protected $casts = [
    	'textbook_used' => 'boolean',
    	'would_retake' => 'boolean',
    	'overall_rating' => 'double',
    	'difficulty_rating' => 'double',
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
     * The custom attributes to append to a JSON response
     * @var array
     */
    protected $appends = [];

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
     * Shorten the `difficulty_rating` attribute to 1 digital place
     * @param  string $value The value of the column
     * @return string        
     */
    public function getDifficultyRatingAttribute($value)
    {
    	return number_format($value, 1);
    }

    /**
     * Get the student who reviewed this professor
     * @return \App\User 
     */
	public function student()
	{
		return $this->belongsTo('\App\User');
	}

	/**
	 * Get the professor that was reviewed
	 * @return \App\Models\Professor\Professor 
	 */
	public function professor()
	{
		return $this->belongsTo('\App\Models\Professor\Professor');
	}
}