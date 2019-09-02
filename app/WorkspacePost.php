<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspacePost extends Model
{
    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function attempted_project()
    {
    	return $this->belongsTo(AttemptedProject::class);
    }

    public function comment_files()
    {
        return $this->hasMany(CommentFile::class);
    }

    public function workspace_post_files()
    {
        return $this->hasMany(WorkspacePostFile::class);
    }
}
