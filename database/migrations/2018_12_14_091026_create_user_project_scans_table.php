<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserProjectScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_project_scans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('project_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('project_owner_id')->nullable();
            $table->integer('count')->default('1');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_project_scans');
    }
}
