<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosTalleresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_talleres', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_final');            
            $table->integer('especialidad_id')->unsigned()->nullable();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');
            $table->integer('instructor_id')->unsigned()->nullable();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->integer('estudio_id')->unsigned()->nullable();
            $table->foreign('estudio_id')->references('id')->on('config_estudios');
            $table->integer('taller_id')->unsigned()->nullable();
            $table->foreign('taller_id')->references('id')->on('talleres');
            $table->string('color_etiqueta');
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
        Schema::drop('horarios_talleres');
    }
}

