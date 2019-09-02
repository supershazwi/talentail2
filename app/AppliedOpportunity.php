<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppliedOpportunity extends Model
{
    //
    public function opportunity() {
    	return $this->belongsTo(Opportunity::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
