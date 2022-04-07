<?php

use Illuminate\Database\Seeder;

class CatagorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('catagories')->insert([

    		'title'=> Str::random(10),
    		
    	]);
    }
}
