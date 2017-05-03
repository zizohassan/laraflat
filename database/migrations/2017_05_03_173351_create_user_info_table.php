<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip' , 20);
            $table->string('iso_code' , 20)->nullable();
            $table->string('country' , 50)->nullable();
            $table->string('city' , 50)->nullable();
            $table->string('state' , 50)->nullable();
            $table->string('state_name' , 50)->nullable();
            $table->string('postal_code' , 50)->nullable();
            $table->string('lat' , 50)->nullable();
            $table->string('lon' , 50)->nullable();
            $table->string('timezone' , 50)->nullable();
            $table->string('continent' , 50)->nullable();
            $table->string('currency' , 50)->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        //
    }
}
