<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetenciesAndTasksReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('competencies_and_tasks_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attempted_project_id');
            $table->boolean('tasks_reviewed');
            $table->boolean('competencies_reviewed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competencies_and_tasks_reviews');
    }
}
