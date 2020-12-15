<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Project extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'projectname', 'projecturl'
        ];

        protected $table = 'ldeq_projects';
    }