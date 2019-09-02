<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkspacePostsTable extends Migration
{
    public function up()
    {
        Schema::create('workspace_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content');
            $table->integer('user_id');
            $table->integer('attempted_project_id');
            $table->string('url');
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
        Schema::dropIfExists('workspace_posts');
    }
}
