<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clases_personalizadas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->string('color_etiqueta');
            $table->string('descripcion');
            $table->string('condiciones');

            $table->integer('especialidad_id')->unsigned();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');
            $table->integer('instructor_id')->unsigned();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->integer('estudio_id')->unsigned();
            $table->foreign('estudio_id')->references('id')->on('config_estudios');

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
        Schema::drop('clases_personalizadas');
    }

}
