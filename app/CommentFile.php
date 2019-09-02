<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentFile extends Model
{
    protected $table = 'comment_files';
    
    public function comment() {
    	return $this->belongsTo(Comment::class);
    }

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