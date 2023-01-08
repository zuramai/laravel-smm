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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->string('phone');
            $table->decimal('balance', 10, 2);
            $table->enum('level', ['Member','Agen','Reseller','Admin','Developer']);
            $table->enum('status', ['active','not active']);
            $table->timestamp('email_verified_at');
            $table->string('api_key');
            $table->text('photo')->nullable();
            $table->foreignId('uplink')->nullable()->constrained('users');
            $table->string('remember_token')->nullable()->default(null);
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
        Schema::dropIfExists('users');
    }
};
