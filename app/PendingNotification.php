<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingNotification extends Model
{
    public function user() {
    	return $this->belongsTo(User::class);
    }
}
