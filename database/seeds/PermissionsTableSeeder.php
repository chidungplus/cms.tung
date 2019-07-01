<?php

use Illuminate\Database\Seeder;
use Zent\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Schema::disableForeignKeyConstraints();
        \DB::table('permissions')->truncate();
        \Schema::enableForeignKeyConstraints();

        Permission::create([
            'name'          => 'customer-view',
            'display_name'  => 'Xem module customer'
        ]);

        Permission::create([
            'name'          => 'customer-create',
            'display_name'  => 'Tạo mới customer'
        ]);

        Permission::create([
            'name'          => 'customer-edit',
            'display_name'  => 'Chỉnh sửa customer'
        ]);

        Permission::create([
            'name'          => 'customer-delete',
            'display_name'  => 'Xoá customer'
        ]);

        Permission::create([
            'name'          => 'user-view',
            'display_name'  => 'Xem module user'
        ]);

        Permission::create([
            'name'          => 'user-create',
            'display_name'  => 'Tạo mới user'
        ]);

        Permission::create([
            'name'          => 'user-edit',
            'display_name'  => 'Chỉnh sửa user'
        ]);

        Permission::create([
            'name'          => 'user-delete',
            'display_name'  => 'Xoá user'
        ]);

        Permission::create([
            'name'          => 'user-role-view',
            'display_name'  => 'Xem vai trò user'
        ]);

        Permission::create([
            'name'          => 'user-role-update',
            'display_name'  => 'Chỉnh sửa vai trò user'
        ]);

        Permission::create([
            'name'          => 'module-view',
            'display_name'  => 'Xem module module'
        ]);

        Permission::create([
            'name'          => 'module-create',
            'display_name'  => 'Tạo mới module'
        ]);

        Permission::create([
            'name'          => 'module-edit',
            'display_name'  => 'Chỉnh sửa module'
        ]);

        Permission::create([
            'name'          => 'module-delete',
            'display_name'  => 'Xoá module'
        ]);

        Permission::create([
            'name'          => 'activity-log-view',
            'display_name'  => 'Xem lịch sử hoạt động'
        ]);

        Permission::create([
            'name'          => 'system-log-view',
            'display_name'  => 'Xem log hệ thống'
        ]);

        Permission::create([
            'name'          => 'system-log-download',
            'display_name'  => 'Tải xuống file log'
        ]);

        Permission::create([
            'name'          => 'system-log-delete',
            'display_name'  => 'Xoá file log'
        ]);

        Permission::create([
            'name'          => 'system-log-truncate',
            'display_name'  => 'Xoá nội dung file log'
        ]);

        Permission::create([
            'name'          => 'permission-view',
            'display_name'  => 'Xem danh sách quyền hạn'
        ]);

        Permission::create([
            'name'          => 'role-view',
            'display_name'  => 'Xem module role'
        ]);

        Permission::create([
            'name'          => 'role-create',
            'display_name'  => 'Tạo mới role'
        ]);

        Permission::create([
            'name'          => 'role-edit',
            'display_name'  => 'Chỉnh sửa role'
        ]);

        Permission::create([
            'name'          => 'role-delete',
            'display_name'  => 'Xoá role'
        ]);

        Permission::create([
            'name'          => 'role-permission-role',
            'display_name'  => 'Xem danh sách quyền hạn của vai trò'
        ]);

        Permission::create([
            'name'          => 'role-permission-update',
            'display_name'  => 'Chỉnh sửa permission role'
        ]);

        Permission::create([
            'name'          => 'job-view',
            'display_name'  => 'Xem danh sách công việc trong hàng chờ'
        ]);
    }
}
