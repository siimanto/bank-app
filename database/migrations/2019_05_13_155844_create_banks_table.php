<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_code')->nullable();
            $table->string('code')->nullable();
            $table->string('rtgs_code')->nullable();
            $table->string('personal_lib')->nullable();
            $table->string('corporate_lib')->nullable();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->tinyInteger('status')->nullable()->unsigned()->comment('1 => Active, 2 => Not Active');
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
        Schema::dropIfExists('banks');
    }
}
