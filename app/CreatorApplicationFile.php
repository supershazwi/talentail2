<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreatorApplicationFile extends Model
{
	protected $table = 'creator_application_files';
    //
    public function creator_application() {
    	return $this->belongsTo(CreatorApplication::class);
    }
}
