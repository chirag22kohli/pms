<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactAndEventTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contactandevents', function (Blueprint $table) {
            $table->increments('id');

            $table->string('user_id')->nullable();
            $table->string('type')->nullable();
            $table->string('json_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        
             Schema::drop('contactandevents');
      
    }

}
