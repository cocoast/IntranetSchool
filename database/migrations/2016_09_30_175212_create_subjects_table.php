<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('asignatura', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->integer('docente_id')->unsigned();
            $table->foreign('docente_id')->references('id')->on('docente');

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
        Schema::drop('asignatura');    }
}
