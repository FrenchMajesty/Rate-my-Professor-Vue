<?php

namespace App\Http\Controllers;

use App\Models\Professor\ReviewTags;
use Illuminate\Http\Request;

class ReviewTagsController extends Controller
{	
	/**
	 * Get all the reviews tags
	 * @return array 
	 */
	public function index()
	{
		return ReviewTags::all();
	}
}
