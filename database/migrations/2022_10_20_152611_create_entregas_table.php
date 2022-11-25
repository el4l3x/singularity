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
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->decimal('total', 8, 2);
            $table->unsignedBigInteger('franquicia_id');
            $table->unsignedBigInteger('entregable_id');
            $table->string('entregable_type');
            $table->string('observaciones')->nullable();

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
        Schema::dropIfExists('entregas');
    }
};
