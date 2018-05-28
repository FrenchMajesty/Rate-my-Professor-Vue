<?php

namespace App\Http\Controllers\Review;

use Validator;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;
use App\Models\School\School;
use App\Models\School\SchoolReview;
use Illuminate\Http\Request;

class SchoolReviewController extends LaravelController
{
	use EloquentBuilderTrait;

	/**
	 * Handle request to search and fetch professors
	 * @return Response           
	 */	
    public function fetch()
    {
        $resourceOptions = $this->parseResourceOptions();

        $query = SchoolReview::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $reviews = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($reviews, $resourceOptions, 'reviews');

        return $this->response($parsedData);
    }

    /**
     * Handle a request to create a new review to a school after validation
     * @param  Request $request Request
     * @return SchoolReview           
     */
    public function create(Request $request)
    {
    	Validator::make($request->all(), [
    		'professor_id' => 'required|exists:professors,id',
    		'user_id' => 'required|exists:users,id',
    		'overall_rating' => 'required|numeric',
    		'location_rating' => 'required|numeric',
    		'facilities_rating' => 'required|numeric',
    		'opportunity_rating' => 'required|numeric',
    		'social_rating' => 'required|numeric',
    	])->validate();

    	$data = $request->only([
    		'professor_id',
    		'user_id',
    		'overall_rating',
    		'location_rating',
    		'facilities_rating',
    		'opportunity_rating',
    		'social_rating',
    	]);

    	return SchoolReview::create($data);
    }

    /**
     * Delete a school review
     * @param  SchoolReview $review The review to delete
     * @return void               
     */
    public function delete(SchoolReview $review)
    {
    	if($review->user_id == Auth::id()) {
    		$errors = ['user_id' => ['You cannot modify the review of another student.']];
    		return response()->json(compact('errors'), 401);
    	}

    	$review->delete();
    }
}
