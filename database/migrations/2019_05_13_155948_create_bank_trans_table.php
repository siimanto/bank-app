<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_trans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trans_id', 50)->nullable()->unique();
            $table->dateTime('trans_time')->nullable();
            $table->integer('bank_account_id')->unsigned()->nullable();
            $table->integer('bank_trans_group_id')->unsigned()->default(1)->nullable();
            $table->string('refference', 50)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1=>Debit, 2=>Credit');
            $table->double('amount', 16, 2)->nullable();
            $table->tinyInteger('status')->default(1)->nullable()->comment('');
            $table->bigInteger('user_id')->unsigned()->nullable()->comment('if null is system');
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
        Schema::dropIfExists('bank_trans');
    }
}
