<?php

namespace App\Http\Controllers;

use Validator;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;
use App\Models\Professor\Professor;
use App\Models\Professor\ProfessorReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProfessorReviewController extends LaravelController
{	
	use EloquentBuilderTrait;

	/**
	 * Handle request to search and fetch professors
	 * @return Response           
	 */	
    public function fetch()
    {
        $resourceOptions = $this->parseResourceOptions();

        $query = ProfessorReview::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $reviews = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($reviews, $resourceOptions, 'reviews');

        return $this->response($parsedData);
    }

	/**
	 * Return a professor review's model
	 * @param  ProfessorReview $review The review entry
	 * @return ProfessorReview                  
	 */
	public function index(ProfessorReview $review)
	{
		return $review;
	}

	/**
	 * Handle the request to add a review to a professor after validation
	 * @param  Request $request Request
	 * @return ProfessorReview           
	 */
	public function create(Request $request)
	{
		Validator::make($request->all(), [
			'professor_id' => 'required|exists:professors,id',
			'overall_rating' => 'required|numeric',
			'difficulty_rating' => 'required|numeric',
			'textbook_used' => 'required|boolean',
			'would_retake' => 'required|boolean',
			'comment' => 'required|string|min:50|max:350',
			'grade_received' => 'required|string',
			'class' => 'required|string',
			'tags_id' => 'required|string',
		])->validate();

		$reviewAlreadyGiven = ProfessorReview::where([
			'user_id' => $request->user()->id,
			'professor_id' => $request->professor_id,
		])->first();

		if($reviewAlreadyGiven) {
			$errors = ['comment' => ['You cannot give two reviews to the same professor.']];
			return response()->json(compact('errors'), 401);
		}

		$review = ProfessorReview::create([
			'user_id' => $request->user()->id,
			'professor_id' => $request->professor_id,
			'overall_rating' => $request->overall_rating,
			'difficulty_rating' => $request->difficulty_rating,
			'textbook_used' => $request->textbook_used,
			'would_retake' => $request->would_retake,
			'comment' => $request->comment,
			'grade_received' => $request->grade_received,
			'class' => $request->class,
		]);

		// Save the tags of the review
		$rows = [];
		$tagsId = explode(',', $request->tags_id);
		foreach($tagsId as $id) {
			$rows[] = [
				'tag_id' => $id, 
				'review_id' => $review->id
			];
		}
		DB::table('review_tags_pivot')->insert($rows);

		return $review;
	}

	/**
	 * Handle the request to update a review after validation
	 * @param  ProfessorReview $review  The review entry to update
	 * @param  Request         $request Request
	 * @return void                   
	 */
	public function update(ProfessorReview $review, Request $request)
	{
		Validator::make($request->all(), [
			'overall_rating' => 'required|numeric',
			'difficulty_rating' => 'required|numeric',
			'textbook_used' => 'required|boolean',
			'would_retake' => 'required|boolean',
			'comment' => 'required|string',
			'grade_received' => 'required|string',
			'class' => 'required|string',
		])->validate();

		if($review->user_id != Auth::id()) {
			$errors = ['message' => ['This entry does not belong to you, you cannot modify it.']];
			return response()->json(compact('errors'), 401);
		}

		$data = $request->only([
			'overall_rating',
			'difficulty_rating',
			'textbook_used',
			'would_retake',
			'comment',
			'grade_received',
			'class',
		]);

		$review->fill($data);
		$review->save();
	}

	/**
	 * Delete the professor review's entry
	 * @param  ProfessorReview $review The entry model to delete
	 * @return void                  
	 */
	public function delete(ProfessorReview $review)
	{
		if($review->user_id != Auth::id()) {
			$errors = ['message' => ['This entry does not belong to you, you cannot delete it.']];
			return response()->json(compact('errors'), 401);
		}

		$review->delete();
	}
}
