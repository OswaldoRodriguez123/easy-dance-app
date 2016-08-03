<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioClaseGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_clase_grupales', function (Blueprint $table) {
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
            $table->integer('clase_grupal_id')->unsigned()->nullable();
            $table->foreign('clase_grupal_id')->references('id')->on('clases_grupales');
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
        Schema::drop('horario_clase_grupales');
    }
}
