<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseFile extends Model
{
    protected $table = 'response_files';
    
    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function answered_exercise() {
        return $this->belongsTo(AnsweredExercise::class);
    }
}
