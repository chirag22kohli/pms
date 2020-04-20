<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserScanPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_scan_packs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->integer('scan_pack_id')->nullable();
            $table->integer('scans')->nullable();
            $table->integer('scans_used')->nullable();
            $table->integer('limit_set')->nullable();
            $table->integer('used_limit')->nullable();
            $table->integer('total_scan_packs')->nullable();
            $table->integer('used_scan_packs')->nullable();
            $table->integer('user_plan_id')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_scan_packs');
    }
}
