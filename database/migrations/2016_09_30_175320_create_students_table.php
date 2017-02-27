<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumno', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->string('rut')->unique();
            $table->string('mail',100);
            $table->string('telefono',15);
            $table->string('direccion',200);
            $table->integer('curso_id')->unsigned();
            $table->integer('apoderado_id')->unsigned();

            $table->foreign('curso_id')->references('id')->on('curso');
            $table->foreign('apoderado_id')->references('id')->on('apoderado');

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
        Schema::drop('alumno');    
        
    }
}
