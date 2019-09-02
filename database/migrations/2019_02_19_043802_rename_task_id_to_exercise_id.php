<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTaskIdToExerciseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('answered_exercises', function (Blueprint $table) {
            $table->renameColumn('task_id', 'exercise_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('answered_exercises', function (Blueprint $table) {
            $table->renameColumn('exercise_id', 'task_id');
        });
    }
}
