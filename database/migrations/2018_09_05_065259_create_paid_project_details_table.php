<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaidProjectDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('paid_project_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('project_admin_id')->nullable();
            $table->string('expriy_date')->nullable();
            $table->integer('current_payment_status')->default('1');
            $table->text('payment_params')->nullable();
            $table->integer('reoccuring_trigger')->default('1');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('paid_project_details');
    }

}
