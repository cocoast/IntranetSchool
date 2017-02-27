<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('curso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('nivel');
            $table->integer('docente_id')->unsigned();

            $table->foreign('docente_id')->references('id')->on('docente');
            $table->timestamps();

        });
           //tabla pivote cursos y asignatura
        Schema::create ('curso_asignatura',function (Blueprint $table){
            $table->increments('id');
            $table->integer('asignatura_id')->unsigned();
            $table->integer('curso_id')->unsigned();

            $table->foreign('asignatura_id')->references('id')->on('asignatura')->onDelete('cascade');
            $table->foreign('curso_id')->references('id')->on('curso')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('curso_asignatura');
        Schema::drop('curso');
        
    }
}
