<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackFile extends Model
{
    protected $table = 'feedback_files';
    //
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function feedback() {
        return $this->belongsTo(Feedback::class);
    }
}
