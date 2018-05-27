<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Professor\Professor;
use App\Models\Professor\ProfessorReview;
use Illuminate\Http\Request;

class ProfessorReviewController extends LaravelController
{	
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
			'user_id' => 'required|exists:users,id',
			'overall_rating' => 'required|numeric',
			'difficulty_rating' => 'required|numeric',
			'textbook_used' => 'required|boolean',
			'would_retake' => 'required|boolean',
			'comment' => 'required|string',
			'grade_received' => 'required|string',
			'class' => 'required|string',
		])->validate();

		$data = $request->only([
			'professor_id',
			'user_id',
			'overall_rating',
			'difficulty_rating',
			'textbook_used',
			'would_retake',
			'comment',
			'grade_received',
			'class',
		]);

		return ProfessorReview::create($data);
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
		$review->delete();
	}
}
