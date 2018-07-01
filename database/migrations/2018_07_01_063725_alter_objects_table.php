<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
           Schema::table('objects', function (Blueprint $table) {
           
            $table->string('pos_top')->after('xpos')->nullable();
            $table->string('pos_left')->after('pos_top')->nullable();
            $table->string('object_image')->after('pos_left')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
