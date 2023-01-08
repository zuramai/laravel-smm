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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('service_categories');
            $table->string('note');
            $table->float('min');
            $table->float('max');
            $table->decimal('price', 10, 2);
            $table->decimal('price_oper', 10, 2);
            $table->decimal('keuntungan', 10, 2);
            $table->bigInteger('pid');
            $table->enum('type', ['basic', 'custom comment', 'comment likes']);
            $table->foreignId('provider_id')->constrained('providers');
            $table->enum('status', ['active', 'not active']);
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
        Schema::dropIfExists('services');
    }
};
