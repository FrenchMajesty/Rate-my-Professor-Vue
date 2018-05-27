<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessorReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('professor_id');
            $table->integer('user_id');
            $table->double('overall_rating', 3, 2);
            $table->double('difficulty_rating', 3, 2);
            $table->string('comment');
            $table->string('class');
            $table->string('grade_received');
            $table->boolean('textbook_used');
            $table->boolean('would_retake');
            $table->boolean('approved')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
