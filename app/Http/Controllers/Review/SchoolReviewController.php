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
     * Return a school review's model
     * @param  SchoolReview $review The review entry
     * @return SchoolReview                  
     */
    public function index(SchoolReview $review)
    {
        return $review;
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
    		'overall' => 'required|numeric',
    		'location' => 'required|numeric',
    		'facilities' => 'required|numeric',
    		'opportunity' => 'required|numeric',
    		'social' => 'required|numeric',
    	])->validate();

    	return SchoolReview::create([
            'professor_id' => $request->professor_id,
            'user_id' => $request->user()->id,
            'overall_rating' => $request->overall,
            'location_rating' => $request->location,
            'facilities_rating' => $request->facilities,
            'opportunity_rating' => $request->opportunity,
            'social_rating' => $request->social,
        ]);
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
