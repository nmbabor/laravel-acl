<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'Primary Info',
            'slug' => 'primary-info',
            'system' => 1,
            'resource' => '',
        ]);
        DB::table('permissions')->insert([
            'name' => 'User',
            'slug' => 'user',
            'system' => 1,
            'resource' => '',
        ]);
        DB::table('permissions')->insert([
            'name' => 'ACL',
            'slug' => 'acl',
            'system' => 1,
            'resource' => '',
        ]);
        DB::table('permissions')->insert([
            'name' => 'Others',
            'slug' => 'others',
            'system' => 1,
            'resource' => '',
        ]);
        DB::table('permissions')->insert([
            'name' => 'Menu',
            'slug' => 'menu',
            'system' => 1,
            'resource' => '',
        ]);
    }
}
