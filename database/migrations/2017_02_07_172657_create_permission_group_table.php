<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePermissionGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('permission_group', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('permission_id')->unsigned();
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
                $table->integer('group_id')->unsigned();
                $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

            });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
    }
}