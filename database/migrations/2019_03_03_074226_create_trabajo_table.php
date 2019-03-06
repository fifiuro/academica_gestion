<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajo', function (Blueprint $table) {
            $table->increments('id_tra');
            $table->integer('id_pe')->unsigned();
            $table->foreign('id_pe')->references('id_pe')->on('persona')->onDelete('cascade');
            $table->integer('id_em')->unsigned();
            $table->foreign('id_em')->references('id_em')->on('empresa')->onDelete('cascade');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('trabajo');
    }
}
