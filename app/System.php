<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class System extends Model
    {
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'system_name', 'system_url'
        ];

        protected $table = 'ldeq_systems';
    }