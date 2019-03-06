<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referencia', function (Blueprint $table) {
            $table->increments('id_ref');
            $table->integer('id_pe')->unsigned();
            $table->foreign('id_pe')->references('id_pe')->on('persona')->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('telefono')->nullable();
            $table->string('celular');
            $table->boolean('estado');
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
        Schema::dropIfExists('referencia');
    }
}
