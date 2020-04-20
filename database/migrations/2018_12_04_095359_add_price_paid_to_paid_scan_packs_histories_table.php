<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPricePaidToPaidScanPacksHistoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('paid_scan_packs_histories', function (Blueprint $table) {
            $table->integer('price_paid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('paid_scan_packs_histories', function (Blueprint $table) {
            //
        });
    }

}
