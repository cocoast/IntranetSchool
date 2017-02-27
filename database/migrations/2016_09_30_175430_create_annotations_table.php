<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('anotacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo');
            $table->date('fecha');
            $table->string('anotacion',200);
            $table->integer('alumno_id')->unsigned();
            $table->integer('asignatura_id')->unsigned();

            $table->foreign('asignatura_id')->references('id')->on('asignatura');
            $table->foreign('alumno_id')->references('id')->on('alumno')->onDelete('cascade');
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
        Schema::drop('anotacion');
    }
}
