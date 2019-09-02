<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endorser extends Model
{
    //
    public function attempted_project() {
    	return $this->belongsTo(AttemptedProject::class);
    }
}
