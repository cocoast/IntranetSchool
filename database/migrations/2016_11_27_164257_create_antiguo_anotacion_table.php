<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntiguoAnotacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antiguo_anotacion', function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_antiguo')->unsigned();
            $table->integer('positivas');
            $table->integer('negativas');
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
        Schema::drop('antiguo_anotacion');
    }
}
