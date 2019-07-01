<?php

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::truncate();

        Module::create([
            'name'  =>  'layout',
            'display_name'  =>  'Layout',
            'module_category_id'    => 2,
            'status'    =>  0
        ]);

        Module::create([
            'name'  =>  'customer',
            'display_name'  =>  'Khách hàng',
            'module_category_id'    =>  2,
            'status'    =>  1
        ]);

        Module::create([
            'name'  =>  'user',
            'display_name'  =>  'Quản trị viên',
            'module_category_id'    =>  2,
            'status'    =>  1
        ]);

        Module::create([
            'name'  =>  'module',
            'display_name'  =>  'Module',
            'module_category_id'    =>  2,
            'status'    =>  1
        ]);

        Module::create([
            'name'  =>  'role',
            'display_name'  =>  'Vai trò',
            'module_category_id'    =>  3,
            'status'    =>  1
        ]);

        Module::create([
            'name'  =>  'permission',
            'display_name'  =>  'Quyền hạn',
            'module_category_id'    =>  3,
            'status'    =>  1
        ]);

        Module::create([
            'name'  =>  'system_log',
            'display_name'  =>  'Log hệ thống',
            'module_category_id'    =>  3,
            'status'    =>  0
        ]);

        Module::create([
            'name'  =>  'activity_log',
            'display_name'  =>  'Lịch sử hoạt động',
            'module_category_id'    =>  3,
            'status'    =>  1
        ]);

        Module::create([
            'name'  =>  'account',
            'display_name'  =>  'Tài khoản Garena',
            'module_category_id'    =>  3,
            'status'    =>  0
        ]);

        Module::create([
            'name'  =>  'account_group',
            'display_name'  =>  'Nhóm tài khoản',
            'module_category_id'    =>  3,
            'status'    =>  1
        ]);

        Module::create([
            'name'  =>  'job',
            'display_name'  =>  'Hàng chờ công việc',
            'module_category_id'    =>  3,
            'status'    =>  1
        ]);
    }
}
