<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
    Schema::create('registro_asistencias', function(Blueprint $table)
        {
            $table->increments('id');
            
            $table->integer('clasegrupal_id')->unsigned();
            $table->foreign('clasegrupal_id')->references('id')->on('clases_grupales');

            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');

            $table->date('fecha');

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
        Schema::drop('registro_asistencias');
    }

}
