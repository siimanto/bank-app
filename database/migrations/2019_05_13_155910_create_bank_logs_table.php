<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank_username', 32)->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->string('event')->nullable();
            $table->text('url')->nullable();
            $table->string('http_code', 8)->nullable();
            $table->string('response_code')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->nullable()->unsigned()->comment('0=> Failed, 1=>Success');
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
        Schema::dropIfExists('bank_logs');
    }
}
