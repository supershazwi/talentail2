<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('projects', function(Blueprint $table) {
            $table->longText('description')->nullable()->change();
            $table->longText('brief')->nullable()->change();
            $table->decimal('hours', 4, 2)->nullable()->change();
            $table->decimal('amount', 8, 2)->nullable()->change();
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
        Schema::table('projects', function(Blueprint $table) {
            $table->text('description')->change();
            $table->longText('brief')->change();
            $table->decimal('hours', 4, 2)->change();
            $table->decimal('amount', 8, 2)->change();
        });
    }
}
