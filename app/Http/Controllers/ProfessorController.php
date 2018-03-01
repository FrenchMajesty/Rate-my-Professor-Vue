<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfessorController extends Controller
{	
	/**
	 * Handle request to search and fetch professors
	 * @param  \Illuminate\Http\Request $request Request
	 * @return \Illuminate\Http\Response           Json Response
	 */	
    public function fetch(Request $request)
    {
    	return ['cool','potato','chips'];
    }

    public function update(Request $request)
    {
    	return 'Congrats Admin ' . $request->user()->name.' !';
    }
}
