<?php

namespace App\Http\Controllers;

use Validator;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;
use Illuminate\Http\Request;
use App\Models\School\School;
use App\Traits\Filters\SchoolQueryFilters;

class SchoolController extends LaravelController
{
    use EloquentBuilderTrait, SchoolQueryFilters;

	/**
	 * Handle request to search and fetch schools
	 * @return \Illuminate\Http\Response           
	 */	
    public function fetch()
    {
        $resourceOptions = $this->parseResourceOptions();

        $query = School::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $schools = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($schools, $resourceOptions, 'schools');

        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

    /**
     * Fetch and return a school entry
     * @param  \App\School\School $school School
     * @return \App\School\School               
     */
    public function index(School $school)
    {
        return $school;
    }

    /**
     * Handle the request to approve/reject a school
     * @param  \App\School\School $school    School
     * @param  \Illuminate\Http\Request   $request Request
     * @return void             
     */
    public function approve(School $school, Request $request)
    {
        Validator::make($request->all(), [
            'status' => 'required|boolean',
        ])->validate();

        $school->approved = $request->status;
        $school->save();
    }

    /**
     * Handle the request to create a new school
     * @param  \Illuminate\Http\Request $request Request
     * @return void          
     */
    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'nickname' => 'required|alpha|max:20',
            'location' => 'required|string|max:255',
            'website' => 'required|active_url|max:255',
        ])->validate();

        School::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'location' => $request->location,
            'website' => $request->website,
        ]);
    }

    /**
     * Handle the request to update a school's information
     * @param  App\School\School $school    School
     * @param  \Illuminate\Http\Request $request Request
     * @return void            
     */
    public function update(School $school, Request $request)
    {
    	Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'nickname' => 'required|alpha|max:20',
            'location' => 'required|string|max:255',
            'website' => 'required|active_url|max:255',
        ])->validate();

        $school->name = $request->name;
        $school->nickname = $request->nickname;
        $school->location = $request->location;
        $school->website = $request->website;
        $school->save();
    }

    /**
     * Delete a school entry
     * @param  App\School\School $school School
     * @return void          
     */
    public function delete(School $school)
    {
        $school->delete();
    }
}
