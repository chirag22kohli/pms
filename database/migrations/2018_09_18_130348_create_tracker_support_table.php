<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackerSupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_support', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('tracker_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('reason')->nullable();
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
        Schema::table('tracker_support', function (Blueprint $table) {
            //
        });
    }
}
