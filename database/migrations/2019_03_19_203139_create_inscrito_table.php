<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscritoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscrito', function (Blueprint $table) {
            $table->increments('id_insc');
            $table->integer('id_cr')->unsigned();
            $table->foreign('id_cr')->references('id_cr')->on('cronograma')->onDelete('cascade');

            $table->integer('id_alu')->unsigned();
            $table->foreign('id_alu')->references('id_alu')->on('alumno')->onDelete('cascade');

            $table->integer('precio');
            $table->integer('tipo_pago');
            $table->integer('num_cuota');
            $table->string('obs')->nullable();
            $table->integer('nota')->default(0);
            $table->integer('estado');

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
        Schema::dropIfExists('inscrito');
    }
}
