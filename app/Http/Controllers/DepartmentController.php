<?php

namespace App\Http\Controllers;

use App\Models\School\Department;
use Illuminate\Http\Request;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

class DepartmentController extends LaravelController
{
    use EloquentBuilderTrait;

	/**
	 * Handle request to search and fetch departments
	 * @return \Illuminate\Http\Response           
	 */	
    public function fetch()
    {
        $resourceOptions = $this->parseResourceOptions();

        $query = Department::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $profs = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($profs, $resourceOptions, 'depts');

        return $this->response($parsedData);
    }

    /**
     * Fetch and return a department entry
     * @param  \App\Models\School\Department $dept Department
     * @return \App\Models\School\Department               
     */
    public function index(Department $dept)
    {
        return $dept;
    }

    public function create(Request $request)
    {
    	# code...
    }

    public function update(Department $dept, Request $request)
    {
    	# code...
    }

    /**
     * Delete a department entry
     * @param  \App\Models\School\Department $dept The department to delete
     * @return void           
     */
    public function delete(Department $dept)
    {
    	$dept->delete();
    }
}
