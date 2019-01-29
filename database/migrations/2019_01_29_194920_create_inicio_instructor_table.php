<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInicioInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inicio_instructor', function (Blueprint $table) {
            $table->increments('id_inin');
            $table->integer('id_cr')->unsigned();
            $table->foreign('id_cr')->references('id_cr')->on('cronograma')->onDelete('cascade');
            $table->integer('id_ins')->unsigned();
            $table->foreign('id_ins')->references('id_ins')->on('instructor');
            $table->integer('c_hora');
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
        Schema::dropIfExists('inicio_instructor');
    }
}
