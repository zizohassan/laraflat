<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title")->nullable();
			$table->text("t")->nullable();
			$table->string("image")->nullable();
			$table->text("photo")->nullable();
			$table->string("file")->nullable();
			$table->text("files")->nullable();
			$table->string("date")->nullable();
			$table->string("icon")->nullable();
			$table->string("url")->nullable();
			$table->string("lng")->nullable();
			$table->string("lat")->nullable();
			$table->string("youtube")->nullable();
			$table->boolean("active")->nullable();
			
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
        Schema::dropIfExists('post');
    }
}
