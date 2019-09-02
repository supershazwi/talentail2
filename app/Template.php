<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    public function template_shots() {
        return $this->hasMany(TemplateShot::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
