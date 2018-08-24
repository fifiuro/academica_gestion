<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronogramaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cronograma', function (Blueprint $table) {
            $table->increments('id_cr');
            $table->integer('id_cu');
            $table->datetime('fecha_inicio');
            $table->datetime('decha_fin');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('dias',15);
            $table->integer('precio')->nullable();
            $table->integer('duracion');
            $table->integer('disponibilidad')->nullable();
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('mes');
            $table->integer('gestion');
            $table->string('obs',255)->nullable();
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
        Schema::dropIfExists('cronograma');
    }
}
