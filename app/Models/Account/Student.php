<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{	
	/**
	 * Get the user model to whom this student entry belongs to
	 * @return \App\User 
	 */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
