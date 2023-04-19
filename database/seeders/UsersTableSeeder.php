<?php

namespace Database\Seeders;

use DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ldeq_users')->insert([
            'username' => 'jvanzeeland',
            'email' => 'jordyvanzeeland@gmail.com',
            'password' => bcrypt('FullStackDev91!'),
            'fullname' => 'Jordy van Zeeland'
        ]);
    }
}
