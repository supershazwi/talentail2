<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    public function answers() {
    	return $this->hasMany(Answer::class);
    }

    public function project() {
    	return $this->belongsTo(Project::class);
    }

    public function user_answers() {
        return $this->hasMany(UserAnswer::class);
    }

    public function answered_tasks() {
        return $this->hasMany(AnsweredTask::class);
    }

    public function exercise_groupings() {
        return $this->hasMany(ExerciseGrouping::class);
    }

    public function exercises() {
        return $this->hasMany(Exercise::class);
    }

    public function answered_exercises() {
        return $this->hasMany(AnsweredExercise::class);
    }

    public function opportunities()
    {
        return $this->belongsToMany(Opportunity::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
