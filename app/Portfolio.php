<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class);
    }

    public function attempted_projects()
    {
        return $this->belongsToMany(AttemptedProject::class);
    }

    public function shopping_cart_line_items() {
        return $this->hasMany(ShoppingCartLineItem::class);
    }
}
