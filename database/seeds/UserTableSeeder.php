<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Developer',
            'email' => 'dev@leamtech.com',
            'password' => bcrypt('123456'),
            'phone_number'=>'018'
        ]);
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@leamtech.com',
            'password' => bcrypt('123456'),
            'phone_number'=>'015'
        ]);
    }
}
