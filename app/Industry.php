<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    //
    public function projects() {
    	return $this->hasMany(Project::class);
    }

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }
}
