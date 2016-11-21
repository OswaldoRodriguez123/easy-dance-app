<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_clases_personalizadas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_final');       
            $table->string('color_etiqueta');     
            $table->integer('especialidad_id')->unsigned()->nullable();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');
            $table->integer('instructor_id')->unsigned()->nullable();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->integer('estudio_id')->unsigned()->nullable();
            $table->foreign('estudio_id')->references('id')->on('config_estudios');
            $table->integer('clase_personalizada_id')->unsigned()->nullable();
            $table->foreign('clase_personalizada_id')->references('id')->on('inscripcion_clase_personalizada');
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
        Schema::drop('horarios_clases_personalizadas');
    }
}
