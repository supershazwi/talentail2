<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetencyScore extends Model
{
	protected $table = 'competency_scores';

    public function role_gained() {
    	return $this->belongsTo(RoleGained::class);
    }

    public function attempted_project() {
        return $this->belongsTo(AttemptedProject::class);
    }

    public function competency() {
    	return $this->belongsTo(Competency::class);
    }
}
