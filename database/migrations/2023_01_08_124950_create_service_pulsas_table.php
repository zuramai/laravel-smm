<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_pulsas', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->decimal('keuntungan', 10, 2);
            $table->enum('status', ['Active', 'Not Active']);
            $table->foreignId('operator_id')->constrained('service_pulsa_operators');
            $table->foreignId('category_id')->constrained('service_categories');
            $table->foreignId('provider_id')->constrained('providers');
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
        Schema::dropIfExists('service_pulsas');
    }
};
