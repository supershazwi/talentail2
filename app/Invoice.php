<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	protected $table = 'invoices';

    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function shopping_cart() {
    	return $this->belongsTo(ShoppingCart::class);
    }

    public function invoice_line_items() {
        return $this->hasMany(InvoiceLineItem::class);
    }
}
