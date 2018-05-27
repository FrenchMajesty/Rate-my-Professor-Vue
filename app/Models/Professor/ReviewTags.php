<?php

namespace App\Models\Professor;

use Illuminate\Database\Eloquent\Model;

class ReviewTags extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
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
	 * Get all the reviews that were given with this tag
	 * @return array
	 */
	public function reviews()
	{
		return $this->belongsToMany('\App\Models\Professor\ProfessorReview', 'review_tags_pivot', 'tag_id', 'review_id');
	}
}
