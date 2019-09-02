<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeShoppingCartTotalToDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('shopping_carts', function (Blueprint $table) {
            $table->decimal('total', 8, 2)->change();
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
        chema::table('shopping_carts', function (Blueprint $table) {
            $table->float('total', 8, 2)->change();
        });
    }
}
