<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessageToActionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('actions', function (Blueprint $table) {
            //
            $table->string('message')->nullable();
            $table->dropColumn('params');
            $table->text('parm')->nullable();
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
