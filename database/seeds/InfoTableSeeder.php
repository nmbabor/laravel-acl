<?php

use Illuminate\Database\Seeder;

class InfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_info')->insert([
            'company_name' => 'Leam ERP',
            'logo' => 'images/default/logo.png',
            'favicon' => 'images/default/favicon.png',
            'address' => 'Dhaka, Bangladesh',
            'mobile_no' => '01xxxxxxxxx',
            'type' => 1,
            'email' => 'admin@gmail.com',
        ]);
    }
}
