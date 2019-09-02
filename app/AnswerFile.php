<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerFile extends Model
{
    //
    public function exercise() {
    	return $this->belongsTo(Exercise::class);
    }
}
