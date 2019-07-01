<?php

use Illuminate\Database\Seeder;
use Zent\Role\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Schema::disableForeignKeyConstraints();
        \DB::table('roles')->truncate();
        \Schema::enableForeignKeyConstraints();

        Role::create([
            'name'  =>  'superadmin',
            'display_name'  =>  'Super Admin'
        ]);

        Role::create([
            'name'  =>  'admin',
            'display_name'  =>  'Admin'
        ]);

        Role::create([
            'name'  =>  'user',
            'display_name'  =>  'User'
        ]);
    }
}
