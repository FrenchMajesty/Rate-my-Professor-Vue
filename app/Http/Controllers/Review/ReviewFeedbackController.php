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
	 * Handle the request to update or save feedback on the review of a professor
	 * @param  Request $request Request
	 * @return array          
	 */
    public function setForProfessor(Request $request)
    {
    	$this->validate($request, [
    		'review_id' => 'required|exists:professor_reviews,id',
    		'positive' => 'required|boolean',
    	]);

    	ProfessorReviewFeedback::updateOrCreate([
    		'ip_address' => $_SERVER['REMOTE_ADDR'],
    		'review_id' => $request->review_id,
    	], ['positive' => $request->positive]);

        return ProfessorReviewFeedback::where('review_id', $request->review_id)->get();
    }
}
