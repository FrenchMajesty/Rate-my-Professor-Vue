<?php

namespace App\Http\Controllers;

use Validator;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;
use Illuminate\Http\Request;
use App\Models\Professor\Professor;
use App\Traits\Filters\ProfessorQueryFilters;

class ProfessorController extends LaravelController
{	
    use EloquentBuilderTrait, ProfessorQueryFilters;

	/**
	 * Handle request to search and fetch professors
	 * @return Response           
	 */	
    public function fetch()
    {
        $resourceOptions = $this->parseResourceOptions();

        $query = Professor::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $profs = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($profs, $resourceOptions, 'profs');

        return $this->response($parsedData);
    }

    /**
     * Fetch and return a professor entry
     * @param  Professor $prof Professor
     * @return Professor               
     */
    public function index(Professor $prof)
    {
        return $prof;
    }

    /**
     * Handle the request to approve/reject a professor
     * @param  Professor $prof    Professor
     * @param  Request   $request Request
     * @return void             
     */
    public function approve(Professor $prof, Request $request)
    {
        Validator::make($request->all(), [
            'status' => 'required|boolean',
        ])->validate();

        $prof->approved = $request->status;
        $prof->save();
    }

    /**
     * Handle the request to create a new professor
     * @param  Request $request Request
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
     * @param  Professor $prof    Professor
     * @param  Request $request Request
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
     * @param  Professor $prof Professor
     * @return void          
     */
    public function delete(Professor $prof)
    {
        $prof->delete();
    }
}
