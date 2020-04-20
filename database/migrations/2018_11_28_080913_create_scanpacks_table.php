<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScanpacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scanpacks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('packname')->nullable();
            $table->integer('scans')->nullable();
            $table->string('price')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scanpacks');
    }
}
