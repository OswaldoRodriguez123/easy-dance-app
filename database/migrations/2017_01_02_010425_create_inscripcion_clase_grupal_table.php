<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionClaseGrupalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_clase_grupal', function(Blueprint $table)
        {
            $table->increments('id');           

            $table->integer('clase_grupal_id')->unsigned();
            $table->foreign('clase_grupal_id')->references('id')->on('clases_grupales');
            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->integer('costo_inscripcion');
            $table->integer('costo_mensualidad');
            $table->date('fecha_pago');
            $table->date('fecha_inscripcion');
            $table->boolean('tiene_mora');

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
        Schema::drop('inscripcion_clase_grupal');
    }

}