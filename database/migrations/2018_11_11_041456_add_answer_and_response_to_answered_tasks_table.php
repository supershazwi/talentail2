<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnswerAndResponseToAnsweredTasksTable extends Migration
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
            $table->longText('answer')->nullable();
            $table->longText('response')->nullable();
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
            $table->dropColumn('answer');
            $table->dropColumn('response');
        });
    }
}
