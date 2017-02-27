<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntiguoCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antiguo_curso',function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_antiguo')->unsigned();
            $table->string('nombre_curso');
            $table->integer('nivel_curso');
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
        Schema::drop('antiguo_curso');
    }
}
