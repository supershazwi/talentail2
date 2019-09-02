<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewedAnsweredTaskFile extends Model
{
	protected $table = 'reviewed_answered_task_files';

    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function answered_task() {
        return $this->belongsTo(AnsweredTask::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
