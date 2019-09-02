<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityPostCommentFile extends Model
{
	protected $table = 'community_post_comment_files';

	public function community_post_comment() {
        return $this->belongsTo(CommunityPostComment::class);
    }
}
