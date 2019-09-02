<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function workspace_post()
    {
        return $this->belongsTo(WorkspacePost::class);
    }

    public function comment_files()
    {
        return $this->hasMany(CommentFile::class);
    }
}
