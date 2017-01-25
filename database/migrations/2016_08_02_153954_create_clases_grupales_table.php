<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clases_grupales', function(Blueprint $table)
        {
            $table->increments('id');  
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');         
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->date('fecha_inicio_preferencial');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->string('color_etiqueta');
            $table->integer('cupo_minimo');
            $table->integer('cupo_maximo');
            $table->integer('cupo_reservacion');
            $table->integer('cantidad_hombres');
            $table->integer('cantidad_mujeres');
            $table->string('link_video');
            $table->string('imagen')->nullable();

            $table->integer('clase_grupal_id')->unsigned()->nullable();
            $table->foreign('clase_grupal_id')->references('id')->on('config_clases_grupales');
            $table->integer('especialidad_id')->unsigned()->nullable();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');
            $table->integer('nivel_baile_id')->unsigned()->nullable();
            $table->foreign('nivel_baile_id')->references('id')->on('config_niveles_baile');
            $table->integer('instructor_id')->unsigned()->nullable();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->integer('estudio_id')->unsigned()->nullable();
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
        Schema::drop('clases_grupales');
    }

}
