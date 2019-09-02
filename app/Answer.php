<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    public function task() {
    	return $this->belongsTo(Task::class);
    }
}
