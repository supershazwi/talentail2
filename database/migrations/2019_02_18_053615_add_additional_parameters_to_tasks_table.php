<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalParametersToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->longtext('brief');
            $table->string('slug');
            $table->string('solution_title');
            $table->longtext('solution_description');
            $table->dropColumn('mcq');
            $table->dropColumn('multiple_select');
            $table->dropColumn('open_ended');
            $table->dropColumn('na');
            $table->dropColumn('file_upload');
            $table->dropColumn('project_id');
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
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->dropColumn('brief');
            $table->dropColumn('slug');
            $table->dropColumn('solution_title');
            $table->dropColumn('solution_description');
            $table->boolean('mcq');
            $table->boolean('multiple_select');
            $table->boolean('open_ended');
            $table->boolean('na');
            $table->boolean('file_upload');
            $table->boolean('project_id');
        });
    }
}
