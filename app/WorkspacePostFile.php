<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspacePostFile extends Model
{
    protected $table = 'workspace_post_files';

    public function workspace_post() {
    	return $this->belongsTo(WorkspacePost::class);
    }

    public function attempted_project() {
    	return $this->belongsTo(AttemptedProject::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
