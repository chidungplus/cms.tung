<?php

use Illuminate\Database\Seeder;
use App\Models\ModuleCategory;

class ModuleCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModuleCategory::truncate();

        ModuleCategory::create([
            'name'  =>  'Chức năng'
        ]);

        ModuleCategory::create([
            'name'  =>  'Quản lý'
        ]);

        ModuleCategory::create([
            'name'  =>  'Công cụ'
        ]);
    }
}
