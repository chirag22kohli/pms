<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterObjectsTableNew extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('objects', function (Blueprint $table) {

            $table->dropColumn('params');
            $table->text('parm')->nullable();
            
        });
         Schema::table('trackers', function (Blueprint $table) {

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
        //
    }

}
