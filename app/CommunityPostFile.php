<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityPostFile extends Model
{
	protected $table = 'community_post_files';

	public function community_post() {
        return $this->belongsTo(CommunityPost::class);
    }
}
