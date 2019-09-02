<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToCommunityPostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('community_post_comments', function (Blueprint $table) {
            //
            $table->integer('community_post_comment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('community_post_comments', function (Blueprint $table) {
            //
            $table->dropColumn('community_post_comment_id');
        });
    }
}
