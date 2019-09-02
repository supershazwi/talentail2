<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
	protected $table = 'communities';

    //
    public function community_posts() {
    	return $this->hasMany(CommunityPost::class);
    }

    public function users() {
    	return $this->belongsToMany(User::class);
    }

}
