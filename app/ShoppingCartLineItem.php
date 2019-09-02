<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCartLineItem extends Model
{
	protected $table = 'shopping_cart_line_items';

    //
    public function project() {
    	return $this->belongsTo(Project::class);
    }

    public function credit() {
    	return $this->belongsTo(Credit::class);
    }

    public function portfolio() {
        return $this->belongsTo(Portfolio::class);
    }

    public function shopping_cart() {
    	return $this->belongsTo(ShoppingCart::class);
    }
}
