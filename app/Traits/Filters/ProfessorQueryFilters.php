<?php 

namespace App\Traits\Filters;

use Illuminate\Database\Eloquent\Builder;

trait ProfessorQueryFilters 
{	
	/**
	 * Filter out the query professor by school
	 * @param  Builder $query          Query Builder
	 * @param  string  $method         Sorting method to use (where, whereIn)
	 * @param  string  $clauseOperator Sorting operator to use (=, >)
	 * @param  int  $value          School ID
	 * @param  boolean  $in             Indicate whether this is an in-array filter
	 * @return void                  
	 */
	public function filterIsApproved(Builder $query, $method, $clauseOperator, $value, $in)
    {
        if ($value) {
            $query->whereIn('approved', [$value]);
        }
    }
}
