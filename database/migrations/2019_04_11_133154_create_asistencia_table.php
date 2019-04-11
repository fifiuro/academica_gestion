<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencia', function (Blueprint $table) {
            $table->increments('id_asis');
            $table->integer('id_cr')->unsigned();
            $table->foreign('id_cr')->references('id_cr')->on('cronograma')->onDelete('cascade');

            $table->integer('id_insc')->unsigned();
            $table->foreign('id_insc')->references('id_insc')->on('inscrito')->onDelete('cascade');

            $table->date('fecha_asis');
            $table->integer('tipo');
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
        Schema::dropIfExists('asistencia');
    }
}
