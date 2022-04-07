<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

    	DB::table('users')->insert([

    		'first_name'=> Str::random(10),
    		'last_name'=>Str::random(10),
    		'email'=>Str::random(10).'@gmail.com',
    		'password'=>Hash::make('password'),
    		'country_code'=>'+91',
    		'phone_number'=> '9878588585',

    	]);

    }
}
