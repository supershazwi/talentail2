<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnsweredExercise extends Model
{
    protected $table = 'answered_exercises';
    
    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function exercise() {
    	return $this->belongsTo(Exercise::class);
    }

    public function task() {
        return $this->belongsTo(Task::class);
    }

    public function answered_exercise_files() {
        return $this->hasMany(AnsweredExerciseFile::class);
    }

    public function reviewed_answered_task_files() {
        return $this->hasMany(ReviewedAnsweredTaskFile::class);
    }

    public function response_files() {
        return $this->hasMany(ResponseFile::class);
    }
}
