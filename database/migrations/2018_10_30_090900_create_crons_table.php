<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crons', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('type')->nullable();
            $table->string('date_logged')->nullable();
            $table->string('message')->nullable();
            $table->string('success')->nullable();
            $table->text('params')->nullable();
            $table->string('user_id')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('project_id')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('crons');
    }
}
