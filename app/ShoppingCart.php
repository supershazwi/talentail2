<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
	protected $table = 'shopping_carts';

    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function shopping_cart_line_items() {
        return $this->hasMany(ShoppingCartLineItem::class);
    }
}
