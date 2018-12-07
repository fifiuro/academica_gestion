<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario', function (Blueprint $table) {
            $table->increments('id_ho');
            $table->integer('id_cr')->unsigned();
            $table->foreign('id_cr')->references('id_cr')->on('cronograma')->onDelete('cascade');
            $table->string('dias');
            $table->string('horarios');
            $table->date('f_inicio');
            $table->date('f_fin');
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
        Schema::dropIfExists('horario');
    }
}
