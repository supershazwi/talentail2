<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    //
    public function role() {
    	return $this->belongsTo(Role::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function competency_scores()
    {
        return $this->hasMany(CompetencyScore::class);
    }
}
