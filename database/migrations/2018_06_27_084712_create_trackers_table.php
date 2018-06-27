<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trackers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('tracker_name')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('project_id')->nullable();
            $table->string('params')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trackers');
    }
}
