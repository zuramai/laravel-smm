<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE services MODIFY COLUMN price float");
        DB::statement("ALTER TABLE services MODIFY COLUMN price_oper float");
        DB::statement("ALTER TABLE services MODIFY COLUMN keuntungan float");
        // Schema::table('services', function (Blueprint $table) {
        //     $table->double('price')->change();
        //     $table->double('price_oper')->change();
        //     $table->double('keuntungan')->change();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
}
