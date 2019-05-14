<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('corp_id')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('password', 256);
            $table->integer('type')->nullable()->unsigned()->comment('1 => Personal, 2 => Corporate');
            $table->integer('bank_id')->nullable()->unsigned();
            $table->tinyInteger('status')->nullable()->unsigned()->comment('1=> Active, 2 => Not Active, 3 => Blocked');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_users');
    }
}
