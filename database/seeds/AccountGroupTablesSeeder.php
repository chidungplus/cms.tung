<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Zent\AccountGroup\Models\AccountGroup;

class AccountGroupTablesSeeder extends Seeder
{
    protected $table_name = 'account_groups';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable($this->table_name))
        {
            AccountGroup::truncate();

            for ( $i = 1; $i < 10 ; $i++)
            {
                AccountGroup::create([
                    'name'  =>  'group ' . $i,
                    'content'   =>  'Nhóm tài khoản số ' . $i,
                    'user_created_id'   =>  1
                ]);
            }
        }
    }
}
