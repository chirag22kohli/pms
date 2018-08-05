<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('user_id')->nullable();
            $table->string('plan_id')->nullable();
            $table->integer('payment_status')->nullable();
            $table->string('payment_params')->nullable();
            $table->date('plan_expiry_date')->nullable();
            $table->integer('created_by')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_plans');
    }
}
