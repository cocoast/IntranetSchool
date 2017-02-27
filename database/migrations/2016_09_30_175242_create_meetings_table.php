<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('reunion', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('contenido',200);
            $table->integer('curso_id')->unsigned();

            $table->foreign('curso_id')->references('id')->on('curso');

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
        Schema::drop('reunion');    }
}
