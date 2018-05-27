<?php

namespace App\Http\Controllers;

use Validator;
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

    /**
     * Handle a request to create a department after validation
     * @param  \Illuminate\Http\Request $request Request
     * @return \App\Models\School\Department           
     */
    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:255|unique:departments',
        ])->validate();

        return Department::create([
            'name' => $request->name,
         ]);
    }

    /**
     * Handle the request to update a department after validation
     * @param  \App\Models\School\Department $dept    The department entry to update
     * @param  \Illuminate\Http\Request    $request Request
     * @return void              
     */
    public function update(Department $dept, Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:255',
        ])->validate();

        $isNameTaken = Department::where('name', $request->name)
            ->whereNotIn('id', $dept->id)
            ->first();

        if($isNameTaken) {
            $errors = ['name' => ['This name is already used.']];
            return response()->json(compact('errors'), 422);
        }

        $dept->name = $request->name;
        $dept->save();
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
