<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInteresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interes', function (Blueprint $table) {
            $table->increments('id_int');
            $table->integer('id_pe')->unsigned();
            $table->foreign('id_pe')->references('id_pe')->on('persona');
            $table->integer('id_cu')->unsigned();
            $table->foreign('id_cu')->references('id_cu')->on('curso');
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
        Schema::dropIfExists('interes');
    }
}
