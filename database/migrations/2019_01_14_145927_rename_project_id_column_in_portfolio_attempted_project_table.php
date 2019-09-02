<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameProjectIdColumnInPortfolioAttemptedProjectTable extends Migration
{
    public function up()
    {
        //
        Schema::table('attempted_project_portfolio', function (Blueprint $table) {
            $table->renameColumn('project_id', 'attempted_project_id');
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
        Schema::table('attempted_project_portfolio', function (Blueprint $table) {
            $table->renameColumn('attempted_project_id', 'project_id');
        });
    }
}
