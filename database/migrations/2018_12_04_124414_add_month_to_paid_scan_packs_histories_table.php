<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonthToPaidScanPacksHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paid_scan_packs_histories', function (Blueprint $table) {
            $table->integer('month')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paid_scan_packs_histories', function (Blueprint $table) {
            //
        });
    }
}
