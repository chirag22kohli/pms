<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_uid', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('uid_id')->nullable();
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
        Schema::table('user_uid', function (Blueprint $table) {
            //
        });
    }
}
