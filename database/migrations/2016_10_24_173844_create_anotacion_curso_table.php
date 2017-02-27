<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnotacionCursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('anotacion_curso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo');
            $table->date('fecha');
            $table->string('anotacion',500);
            $table->integer('curso_id')->unsigned();
            $table->integer('asignatura_id')->unsigned();

            $table->foreign('curso_id')->references('id')->on('curso')->onDelete('cascade');
            $table->foreign('asignatura_id')->references('id')->on('asignatura')->onDelete('cascade');

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
        Schema::drop('anotacion_curso');
    }
}
