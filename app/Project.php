<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    public function role() {
    	return $this->belongsTo(Role::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function tasks() {
    	return $this->hasMany(Task::class);
    }

    public function shopping_cart_line_items() {
        return $this->hasMany(ShoppingCartLineItem::class);
    }

    public function invoice_line_items() {
        return $this->hasMany(InvoiceLineItem::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function industry() {
        return $this->belongsTo(Industry::class);
    }

    public function competencies()
    {
        return $this->belongsToMany(Competency::class);
    }

    public function attempted_projects() {
        return $this->hasMany(AttemptedProject::class);
    }

    public function reviewed_answered_task_files() {
        return $this->hasMany(ReviewedAnsweredTaskFile::class);
    }

    public function answered_task_files() {
        return $this->hasMany(AnsweredTaskFile::class);
    }

    public function answered_tasks() {
        return $this->hasMany(AnsweredTask::class);
    }
}
