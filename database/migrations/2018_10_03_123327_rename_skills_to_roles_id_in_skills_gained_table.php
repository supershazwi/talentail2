<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSkillsToRolesIdInSkillsGainedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('skills_gained', function (Blueprint $table) {
            $table->renameColumn('skill_id', 'role_id');
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
        Schema::table('skills_gained', function (Blueprint $table) {
            $table->renameColumn('role_id', 'skill_id');
        });
    }
}
