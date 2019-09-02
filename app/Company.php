<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    public function opportunities() {
    	return $this->hasMany(Opportunity::class);
    }

    public function company_applications() {
        return $this->hasMany(CompanyApplication::class);
    }
}
