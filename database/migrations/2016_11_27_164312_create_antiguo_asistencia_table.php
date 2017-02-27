<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntiguoAsistenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antiguo_asistencia',function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_antiguo')->unsigned();
            $table->integer('asistencia');
            $table->integer('inasistencia');
            $table->integer('ano');

            $table->foreign('id_antiguo')->references('id')->on('antiguo')->onDelete('cascade');

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
        Schema::drop('antiguo_asistencia');
    }
}
