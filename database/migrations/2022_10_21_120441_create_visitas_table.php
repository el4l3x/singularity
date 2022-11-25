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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->time('entrada');
            $table->time('salida')->nullable();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('franquicia_id');
            $table->unsignedBigInteger('visitable_id');
            $table->string('visitable_type');

            $table->foreign('franquicia_id')->references('id')->on('franquicias')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('visitas');
    }
};
