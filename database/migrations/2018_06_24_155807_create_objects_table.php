<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('xpos')->nullable();
            $table->string('ypos')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('project_id')->nullable();
            $table->string('type')->nullable();
            $table->string('object_div')->nullable();
            $table->integer('user_id')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('objects');
    }
}
