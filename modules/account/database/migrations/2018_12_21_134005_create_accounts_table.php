<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_account_id')->comment('Id group account');
            $table->string('username')->comment('usename of account');
            $table->string('password')->comment('password of account');
            $table->string('password_new')->comment('password new, use it if not null')->nullable();
            $table->integer('status')->comment('-1: vua tao moi, 0: da doi mat khau thanh cong, != 0 da thuc hien doi mat khau')->default(-1);
            $table->string('message')->comment('msg tra ve tu api')->nullable();
            $table->integer('is_submit')->comment('flag check trang thai da submit toi api hay chua, 1: da submit, 0: chua submit')->default(0);
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
