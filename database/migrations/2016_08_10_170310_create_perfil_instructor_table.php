<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_instructor', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('instructor_id')->unsigned();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->integer('tiempo_experiencia_instructor');
            $table->integer('genero_instructor');
            $table->integer('cantidad_horas');
            $table->integer('titulos_instructor');
            $table->integer('invitacion_evento');
            $table->integer('organizador');
            $table->integer('tiempo_experiencia_bailador');
            $table->integer('genero_bailador');
            $table->integer('participacion_coreografia');
            $table->integer('montajes');
            $table->integer('titulos_bailador');
            $table->integer('participacion_escenario');

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
        Schema::drop('perfil_instructor');
    }

}
