<?php

namespace App\Http\Controllers;

use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;
use Illuminate\Http\Request;
use App\Professor\Professor;

class ProfessorController extends LaravelController
{	
    use EloquentBuilderTrait;

	/**
	 * Handle request to search and fetch professors
	 * @return \Illuminate\Http\Response           Json Response
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
