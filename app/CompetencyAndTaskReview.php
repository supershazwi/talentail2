<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetencyAndTaskReview extends Model
{
	protected $table = 'competencies_and_tasks_reviews';
    //
    public function attempted_project() {
    	return $this->belongsTo(AttemptedProject::class);
    }
}
