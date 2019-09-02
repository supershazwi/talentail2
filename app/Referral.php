<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    //
    public function referrer() {
    	return $this->belongsTo(User::class);
    }

    public function referred() {
    	return $this->belongsTo(User::class);
    }
}
