<?php

namespace App\Http\Controllers;

use Validator;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;
use Illuminate\Http\Request;
use App\Professor\Professor;

class ProfessorController extends LaravelController
{	
    use EloquentBuilderTrait;

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
     * Handle the request to create a new professor
     * @param  \Illuminate\Http\Request $request Request
     * @return \Illuminate\Http\Response           
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

    public function update(Professor $prof, Request $request)
    {
    	$this->validate($request, [
    		'firstname' => 'required|string',
    	]);
    }

    protected function filterSchool(Builder $query, $method, $clauseOperator, $value, $in)
    {
        // check if value is true
        if ($value) {
            $query->whereIn('schools.id', [$value]);
        }
    }
}
