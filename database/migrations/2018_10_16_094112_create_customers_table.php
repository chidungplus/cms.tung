<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->tinyInteger('status')->default(0)->comment('0: deactive, 1: active');
            $table->rememberToken();
            $table->string('name')->nullable();
            $table->tinyInteger('gender')->default(0)->comment('0: Female, 1: Male');
            $table->string('birthday')->nullable()->comment('Y-m-d H:i:s');
            $table->string('mobile')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0: normal, 1: vip');
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
        Schema::dropIfExists('customers');
    }
}
