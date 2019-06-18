<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAPIsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('order_end_point');
            $table->text('order_success_response');
            $table->text('order_method');
            $table->text('status_end_point');
            $table->text('status_success_response');
            $table->text('status_method');
            $table->string('order_id_key');
            $table->string('start_counter_key');
            $table->string('status_key');
            $table->string('remains_key');
            $table->boolean('process_all_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apis');
    }
}
