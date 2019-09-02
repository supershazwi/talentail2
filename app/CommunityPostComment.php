<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityPostComment extends Model
{
	protected $table = 'community_post_comments';

	public function community_post() {
        return $this->belongsTo(CommunityPost::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function nested_comments()
    {
        return $this->hasMany(CommunityPostComment::class, 'community_post_comment_id');
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function community_post_comment_files() {
        return $this->hasMany(CommunityPostCommentFile::class);
    }
}
