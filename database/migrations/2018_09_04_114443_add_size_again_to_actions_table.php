<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSizeAgainToActionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('actions', function (Blueprint $table) {
            //
            $table->string('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('actions', function (Blueprint $table) {
            //
        });
    }

}
