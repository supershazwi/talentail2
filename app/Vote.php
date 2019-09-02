<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    //
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function community_post() {
    	return $this->belongsTo(CommunityPost::class);
    }

    public function community_post_comment() {
    	return $this->belongsTo(CommunityPostComment::class);
    }
}
