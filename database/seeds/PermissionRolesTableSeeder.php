<?php

use Illuminate\Database\Seeder;
use Zent\Role\Models\RoleUser;
use Zent\Permission\Models\Permission;
use Zent\Permission\Models\PermissionRole;

class PermissionRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoleUser::truncate();
        PermissionRole::truncate();

        RoleUser::create([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        $permissions = Permission::all();

        foreach ($permissions as $key => $permission) {
            PermissionRole::create([
                'role_id' => 1,
                'permission_id' => $permission->id
            ]);
        }
    }
}
