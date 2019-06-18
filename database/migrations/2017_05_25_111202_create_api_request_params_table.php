<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiRequestParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_request_params', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('param_key');
            $table->string('param_value');
            $table->string('param_type');
            $table->string('api_type');
            $table->unsignedInteger('api_id');
            $table->timestamps();
            $table->foreign('api_id')
                ->references('id')->on('apis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_request_params');
    }
}
