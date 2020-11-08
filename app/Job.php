<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['job_title', 'hours', 'salary', 'intro', 'tasks', 'skills', 'circumstances'];
}
