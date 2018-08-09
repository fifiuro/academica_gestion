<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecialidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialidad', function (Blueprint $table) {
            $table->increments('id_esp');
            $table->integer('id_cu')->unsigned();
            $table->foreign('id_cu')->references('id_cu')->on('curso');
            $table->integer('id_ins')->unsigned();
            $table->foreign('id_ins')->references('id_ins')->on('instructor')->onDelete('cascade');
            $table->boolean('certificacion')->default(true);
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
        Schema::dropIfExists('especialidad');
    }
}
