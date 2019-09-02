<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateShot extends Model
{
    //
    public function template() {
    	return $this->belongsTo(Template::class);
    }
}
