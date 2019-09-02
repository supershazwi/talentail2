<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleGained extends Model
{
	protected $table = 'roles_gained';

    //
    public function competencies() {
    	return $this->hasMany(Competency::class);
    }

    public function role() {
    	return $this->belongsTo(Role::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function competency_scores() {
        return $this->hasMany(CompetencyScore::class);
    }
}
