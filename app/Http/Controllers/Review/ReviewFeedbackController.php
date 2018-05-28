<?php

namespace App\Http\Controllers\Review;

use App\Models\School\School;
use App\Models\Professor\Professor;
use App\Models\Professor\ReviewFeedback as ProfessorReviewFeedback;
use App\Models\School\ReviewFeedback as SchoolReviewFeedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewFeedbackController extends Controller
{
    /**
     * Get all the feedback for reviews of a professor
     * @param  string $id The ID of the professor
     * @return array     
     */
    public function professor(string $id)
    {
        $reviews = Professor::findorFail($id)->reviews;
        return ProfessorReviewFeedback::whereIn('review_id', $reviews->pluck('id'))->get();
    }

	/**
	 * Handle the request to update or save feedback on the review of a professor
	 * @param  Request $request Request
	 * @return \Professor\ReviewFeedback           
	 */
    public function setForProfessor(Request $request)
    {
    	$this->validate($request, [
    		'review_id' => 'required|exists:professor_reviews,id',
    		'positive' => 'required|boolean',
    	]);

    	return ProfessorReviewFeedback::updateOrCreate([
    		'ip_address' => $_SERVER['REMOTE_ADDR'],
    		'review_id' => $request->review_id,
    	], ['positive' => $request->positive]);
    }
}
