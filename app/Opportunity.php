<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    //
    public function company() {
    	return $this->belongsTo(Company::class);
    }

    public function role() {
    	return $this->belongsTo(Role::class);
    }

    public function exercise_groupings() {
        return $this->hasMany(ExerciseGrouping::class);
    }

    public function applied_opportunities() {
        return $this->hasMany(AppliedOpportunity::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function exercises() {
        return $this->belongsToMany(Exercise::class);
    }
}
