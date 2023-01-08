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
        Schema::create('order_pulsas', function (Blueprint $table) {
            $table->id();
            $table->string('oid');
            $table->string('poid');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('service_id')->constrained('services');
            $table->decimal('price', 10, 2);
            $table->string('data');
            $table->string('sn');
            $table->enum('status', ['Success','Error','Pending']);
            $table->enum('place_from', ['WEB', 'API']);
            $table->boolean('refund');
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
        Schema::dropIfExists('order_pulsas');
    }
};
