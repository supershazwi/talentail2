<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAnswerAndResponseFromAnsweredTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answered_tasks', function (Blueprint $table) {
            //
            $table->dropColumn('answer');
            $table->dropColumn('response');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answered_tasks', function (Blueprint $table) {
            //
            $table->string('answer');
            $table->string('response');
        });
    }
}
