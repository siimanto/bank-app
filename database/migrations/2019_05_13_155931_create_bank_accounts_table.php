<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bank_user_id')->unsigned();
            $table->string('number')->unique();
            $table->string('name')->nullable();
            $table->double('saldo', 16, 2)->nullable();
            $table->string('telegram_id', 50)->nullable();
            $table->tinyInteger('delay_job_minutes')->nullable()->comment('Range in minutes');
            $table->tinyInteger('daily_job_status')->default(2)->nullable()->comment('1 => Active, 2 => Inactive');
            $table->tinyInteger('type')->unsigned()->nullable()->comment('1 => All, 2 => Check Saldo, 3 => Get Mutasi');
            $table->tinyInteger('status')->default(2)->comment('1 => Active, 2 => Inactive');
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
        Schema::dropIfExists('bank_accounts');
    }
}
