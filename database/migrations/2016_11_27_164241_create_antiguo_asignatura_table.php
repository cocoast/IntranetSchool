<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntiguoAsignaturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antiguo_asignatura',function (Blueprint $table){
            $table->increments('id');
            $table->string('nombre_asignatura');
            $table->integer('id_antiguo')->unsigned();
            $table->integer('promedio_s1');
            $table->integer('promedio_s2');
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
        Schema::drop('antiguo_asignatura');
    }
}
