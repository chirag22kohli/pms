<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProjectsForSubscribeTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('projects', function (Blueprint $table) {
            //

            $table->integer('newSubscribeTrigger')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }

}
