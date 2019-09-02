<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLessonAndInterviewIdToShoppingCartLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shopping_cart_line_items', function (Blueprint $table) {
            //
            $table->integer('lesson_id');
            $table->integer('interview_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shopping_cart_line_items', function (Blueprint $table) {
            //
            $table->dropColumn('lesson_id');
            $table->dropColumn('interview_id');
        });
    }
}
