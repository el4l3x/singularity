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
        Schema::create('franquicias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('actividad');
            $table->string('rif');
            $table->string('control_factura')->default('00000000');
            $table->string('control_presupuesto')->default('00000000');
            $table->string('control_entrega')->default('00000000');
            $table->string('factura')->default('00000000');
            $table->string('presupuesto')->default('00000000');
            $table->string('entrega')->default('00000000');

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
        Schema::dropIfExists('franquicias');
    }
};
