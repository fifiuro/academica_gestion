<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno', function (Blueprint $table) {
            $table->increments('id_alu');
            $table->integer('id_pe')->unsigned();
            $table->foreign('id_pe')->references('id_pe')->on('persona')->onDelete('cascade');
            $table->string('dir_dom', 255);
            $table->string('tel_tra', 40);
            $table->string('dir_tra', 255);
            $table->string('nombre_ref', 50);
            $table->string('tel_ref', 40);
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
        Schema::dropIfExists('alumno');
    }
}
