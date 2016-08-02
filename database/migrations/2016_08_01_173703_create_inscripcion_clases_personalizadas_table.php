<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_clase_personalizada', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('clase_personalizada_id')->unsigned();
            $table->foreign('clase_personalizada_id')->references('id')->on('clases_personalizadas');
            $table->integer('alumno_id')->unsigned();
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->integer('especialidad_id')->unsigned();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');
            $table->integer('instructor_id')->unsigned();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->integer('estudio_id')->unsigned();
            $table->foreign('estudio_id')->references('id')->on('config_estudios');

            $table->boolean('estatus')->default(1);
            $table->string('razon_cancelacion')->nullable()->default(null);

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
        Schema::drop('inscripcion_clase_personalizada');
    }

}
