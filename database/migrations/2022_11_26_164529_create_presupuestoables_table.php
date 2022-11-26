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
        Schema::create('presupuestoables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('presupuesto_id');
            $table->unsignedBigInteger('presupuestoable_id');
            $table->string('presupuestoable_type');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->string('descripcion')->nullable();

            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('presupuestoables');
    }
};
