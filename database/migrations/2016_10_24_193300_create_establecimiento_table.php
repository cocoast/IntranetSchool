<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstablecimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('establecimiento', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nombre');
        $table->string('telefono');
        $table->string('direccion');
        $table->string('mail');
        $table->string('director');
        $table->string('rutdirec');
        $table->string('mail_director');
        $table->string('telefono_director');
        $table->string('logo');
        $table->date('s1inicio');
        $table->date('s1fin');
        $table->date('s2inicio');
        $table->date('s2fin');

        $table->timestamps();
    });

    /**
     * Reverse the migrations.
     *
     * @return void
     */
  }
    public function down()
    {
        Schema::drop('establecimiento');
    }
}
