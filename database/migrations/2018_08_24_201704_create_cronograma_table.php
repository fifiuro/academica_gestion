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
            $table->integer('id_cu')->unsigned();
            $table->foreign('id_cu')->references('id_cu')->on('curso');
            $table->integer('precio')->default(0);
            $table->integer('duracion')->default(0);
            $table->integer('disponibilidad')->default(0);
            $table->integer('id')->unsigned();
            $table->foreign('id')->references('id_pe')->on('users');
            $table->integer('mes');
            $table->integer('gestion');
            $table->string('obs',255)->nullable();
            $table->integer('estado')->default('1');
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
