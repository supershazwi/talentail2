<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttemptedProjectIdToAnsweredTaskFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answered_task_files', function (Blueprint $table) {
            //
            $table->integer('attempted_project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answered_task_files', function (Blueprint $table) {
            //
            $table->dropColumn('attempted_project_id');
        });
    }
}
