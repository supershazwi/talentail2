<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function role() {
    	return $this->belongsTo(Role::class);
    }

    public function tasks() {
        return $this->belongsToMany(Task::class);
    }
}
