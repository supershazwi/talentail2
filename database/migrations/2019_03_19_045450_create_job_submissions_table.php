<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('role_id');
            $table->string('company');
            $table->string('slug');
            $table->longText('description');
            $table->string('location');
            $table->string('type');
            $table->string('level');
            $table->integer('user_id');
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
        Schema::dropIfExists('opportunity_submissions');
    }
}
