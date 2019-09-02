<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    //
    public function feedback_files() {
    	return $this->hasMany(FeedbackFile::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
