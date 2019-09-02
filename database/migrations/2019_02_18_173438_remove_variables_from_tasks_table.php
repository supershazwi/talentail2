<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveVariablesFromTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->dropColumn('category_id');
            $table->dropColumn('brief');
            $table->dropColumn('solution_title');
            $table->dropColumn('solution_description');
            $table->dropColumn('duration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
            $table->integer('category_id');
            $table->longText('brief');
            $table->string('solution_title');
            $table->longText('solution_description');
            $table->string('duration');
        });
    }
}
