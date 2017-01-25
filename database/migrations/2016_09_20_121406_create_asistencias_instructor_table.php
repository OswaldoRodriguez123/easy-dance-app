<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciasInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias_instructor', function(Blueprint $table)
        {
            $table->increments('id');  

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');         

            $table->integer('instructor_id')->unsigned();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->integer('clase_grupal_id')->unsigned();
            $table->foreign('clase_grupal_id')->references('id')->on('clases_grupales');
            $table->date('fecha');
            $table->time('hora');
            $table->time('hora_salida');
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
        Schema::drop('asistencias_instructor');
    }
}
