<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
	protected $table = 'community_posts';

    public function community() {
        return $this->belongsTo(Community::class);
    }

    public function community_post_comments() {
        return $this->hasMany(CommunityPostComment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function community_post_files() {
        return $this->hasMany(CommunityPostFile::class);
    }
}
