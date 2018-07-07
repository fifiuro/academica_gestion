<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('id_pe');
            $table->string('nombre', 50);
            $table->string('apellidos', 80);
            $table->string('ci', 15);
            $table->integer('id_dep')->unsigned();
            $table->foreign('id_dep')->references('id_dep')->on('departamento');
            $table->string('tel_dom', 40);
            $table->string('tel_of', 40);
            $table->string('celular', 40);
            $table->string('email', 100);
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
        Schema::dropIfExists('persona');
    }
}
