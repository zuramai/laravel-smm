<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CombineProvidersApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apis', function (Blueprint $table) {
            $table->string('api_key');
            $table->text('additional');
            $table->string('link');
            $table->enum('type', ['PULSA',"SOSMED"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apis', function (Blueprint $table) {
            //
        });
    }
}
