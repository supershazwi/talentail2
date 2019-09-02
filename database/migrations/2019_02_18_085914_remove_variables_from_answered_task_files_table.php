<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveVariablesFromAnsweredTaskFilesTable extends Migration
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
            $table->dropColumn('project_id');
            $table->dropColumn('attempted_project_id');
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
            $table->integer('project_id');
            $table->integer('attempted_project_id');
        });
    }
}
