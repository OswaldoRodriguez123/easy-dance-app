<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredencialesAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credenciales_alumno', function(Blueprint $table)
        {
            $table->increments('id');  

            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos'); 

            $table->integer('clase_grupal_id')->unsigned()->nullable()->default(null);
            $table->foreign('clase_grupal_id')->references('id')->on('clases_grupales');          

            $table->date('fecha_vencimiento');
            $table->integer('dias_vencimiento');
            $table->integer('cantidad');
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
        Schema::drop('credenciales_alumno');
    }
}
