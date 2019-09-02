<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseGrouping extends Model
{
    protected $table = 'exercise_groupings';
    
    public function task() {
        return $this->belongsTo(Task::class);
    }

    public function opportunity() {
        return $this->belongsTo(Opportunity::class);
    }

    public function exercises() {
    	return $this->belongsToMany(Exercise::class);
    }
}
