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
        Schema::create('entregables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrega_id');
            $table->unsignedBigInteger('entregable_id');
            $table->string('entregable_type');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->string('descripcion')->nullable();

            $table->foreign('entrega_id')->references('id')->on('entregas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('entregables');
    }
};
