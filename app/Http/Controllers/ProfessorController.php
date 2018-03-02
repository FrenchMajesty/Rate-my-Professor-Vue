<?php

namespace App\Http\Controllers;

use Validator;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;
use Illuminate\Http\Request;
use App\Professor\Professor;
use App\Traits\Filters\ProfessorQueryFilters;

class ProfessorController extends LaravelController
{	
    use EloquentBuilderTrait, ProfessorQueryFilters;

	/**
	 * Handle request to search and fetch professors
	 * @return \Illuminate\Http\Response           
	 */	
    public function fetch()
    {
        $resourceOptions = $this->parseResourceOptions();

        $query = Professor::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $books = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($books, $resourceOptions, 'users');

        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

    /**
     * Fetch and return a professor entry
     * @param  \App\Professor\Professor $prof Professor
     * @return \App\Professor\Professor               
     */
    public function index(Professor $prof)
    {
        return $prof;
    }

    /**
     * Handle the request to create a new professor
     * @param  \Illuminate\Http\Request $request Request
     * @return void          
     */
    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'firstname' => 'required|alpha_dash|max:25',
            'lastname' => 'required|alpha_dash|max:30',
            'school_id' => 'required|numeric|exists:schools,id',
            'department_id' => 'required|numeric|exists:departments,id',
            'directory_url' => 'nullable|url',
        ])->validate();

        Professor::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'school_id' => $request->school_id,
            'department_id' => $request->department_id,
            'directory_url' => $request->directory_url,
        ]);
    }

    /**
     * Handle the request to update a professor's information
     * @param  App\Professor\Professor $prof    Professor
     * @param  \Illuminate\Http\Request $request Request
     * @return void            
     */
    public function update(Professor $prof, Request $request)
    {
    	Validator::make($request->all() , [ 
            'firstname' => 'required|alpha_dash|max:25',
            'lastname' => 'required|alpha_dash|max:30',
            'school_id' => 'required|numeric|exists:schools,id',
            'department_id' => 'required|numeric|exists:departments,id',
            'directory_url' => 'nullable|url',
        ])->validate();

        $prof->firstname = $request->firstname;
        $prof->lastname = $request->lastname;
        $prof->school_id = $request->school_id;
        $prof->department_id = $request->department_id;
        $prof->directory_url = $request->directory_url;
        $prof->save();
    }

    /**
     * Delete a professor entry
     * @param  App\Professor\Professor $prof Professor
     * @return void          
     */
    public function delete(Professor $prof)
    {
        $prof->delete();
    }
}
