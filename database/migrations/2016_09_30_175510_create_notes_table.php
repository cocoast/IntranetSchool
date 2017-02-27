<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('notas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('nota');
            $table->string('observacion');
            $table->integer('alumno_id')->unsigned();
            $table->integer('asignatura_id')->unsigned();

            $table->foreign('alumno_id')->references('id')->on('alumno')->onDelete('cascade');
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
        Schema::drop('notas');    }
}
