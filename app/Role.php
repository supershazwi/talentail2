<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function projects() {
    	return $this->hasMany(Project::class);
    }

    public function opportunities() {
    	return $this->hasMany(Opportunity::class);
    }

    public function exercises() {
        return $this->hasMany(Exercise::class);
    }

    public function competencies() {
    	return $this->hasMany(Competency::class);
    }

    public function roles_gained() {
        return $this->hasMany(RoleGained::class);
    }

    public function portfolios() {
        return $this->hasMany(Portfolio::class);
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
