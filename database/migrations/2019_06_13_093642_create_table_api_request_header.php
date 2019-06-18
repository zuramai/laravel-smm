<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableApiRequestHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_request_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('header_key');
            $table->string('header_value');
            $table->string('header_type');
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
        Schema::dropIfExists('api_request_headers');
    }
}
