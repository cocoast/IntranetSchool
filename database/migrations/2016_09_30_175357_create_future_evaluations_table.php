<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFutureEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('futuraevaluacion', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('contenido',200);
            $table->integer('curso_id')->unsigned();
            $table->integer('asignatura_id')->unsigned();

            $table->foreign('curso_id')->references('id')->on('curso');
            $table->foreign('asignatura_id')->references('id')->on('asignatura');
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
        Schema::drop('futuraevaluacion');    }
}
