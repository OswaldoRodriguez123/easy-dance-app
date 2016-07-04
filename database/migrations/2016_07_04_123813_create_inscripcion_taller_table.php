<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionTallerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_taller', function(Blueprint $table)
        {
            $table->increments('id');           

            $table->integer('taller_id')->unsigned();
            $table->foreign('taller_id')->references('id')->on('talleres');
            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inscripcion_taller');
    }
}
