<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Professor\Professor;
use App\Models\Professor\ProfessorReview;
use Illuminate\Http\Request;

class ProfessorReviewController extends Controller
{		
	/**
	 * Return all the reviews a particular professor has received
	 * @param  Professor $prof The professor entry
	 * @return array          
	 */
	public function professor(Professor $prof)
	{
		return $prof->reviews();
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
			'comment' => 'required|string',
			'grade_received' => 'required|string',
			'class' => 'required|string',
			'tags_id' => 'required|string',
		])->validate();

		$reviewAlreadyGiven = ProfessorReview::where([
			'user_id' => $request->user()->id,
			'professor_id' => $request->professor_id,
		])->first();

		if($reviewAlreadyGiven) {
			$errors = ['professor_id' => ['You cannot give two reviews to the same professor.']];
			return response()->json(compact('errors'), 401);
		}

		$tagsId = explode(',', $request->tags_id);
		foreach($tagsId as $id) {
			// do something with the tags..
		}

		return ProfessorReview::create([
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
