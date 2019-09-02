<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLineItem extends Model
{
	protected $table = 'invoice_line_items';

    public function project() {
    	return $this->belongsTo(Project::class);
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }
}
