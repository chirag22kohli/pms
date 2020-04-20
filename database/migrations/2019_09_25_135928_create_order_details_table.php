<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('order_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('attributes')->nullable();
            $table->string('attribute_options')->nullable();
            $table->integer('quantity')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_details');
    }
}
