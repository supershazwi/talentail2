<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSkillsGainedIdToSkillGainedId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('competency_scores', function (Blueprint $table) {
            $table->renameColumn('skills_gained_id', 'skill_gained_id');
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
        Schema::table('competency_scores', function (Blueprint $table) {
            $table->renameColumn('skill_gained_id', 'skills_gained_id');
        });
    }
}
