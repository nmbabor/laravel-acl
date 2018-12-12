<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'system' => 1,
            'description' => 'Super Admins',
        ]);
        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'admin',
            'system' => 1,
            'description' => 'Admin role',
        ]);
        DB::table('roles')->insert([
            'name' => 'Developer',
            'slug' => 'developer',
            'system' => 1,
            'description' => 'Developer Mode',
        ]);
    }
}
