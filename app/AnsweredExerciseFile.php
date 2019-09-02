<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnsweredExerciseFile extends Model
{
	protected $table = 'answered_exercise_files';

    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function answered_exercise() {
        return $this->belongsTo(AnsweredExercise::class);
    }
}
