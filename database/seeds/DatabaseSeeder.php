<?php

use Illuminate\Database\Seeder;
use App\User;
use App\School\School;
use App\Professor\Professor;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class,10)->create();
        factory(School::class,2)->create();
    	factory(Professor::class, 4)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
