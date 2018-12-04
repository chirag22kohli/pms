<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaidScanPacksHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_scan_packs_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->integer('scan_pack_id')->nullable();
            $table->date('date_purchased')->nullable();
            $table->integer('scans_credited')->nullable();
            $table->text('payment_params')->nullable();
            $table->string('payment_type')->nullable();
            $table->integer('payment_status')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('paid_scan_packs_histories');
    }
}
