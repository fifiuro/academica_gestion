<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso', function (Blueprint $table) {
            $table->increments('id_cu');
            $table->string('codigo',12);
            $table->string('nombre',255);
            $table->integer('duracion',3);
            $table->string('nom_corto',20);
            $table->integer('precio',5)->nullable();
            $table->integer('categoria')->unsigned();
            $table->foreign('categoria')->references('id_cat')->on('categoria');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('curso');
    }
}
