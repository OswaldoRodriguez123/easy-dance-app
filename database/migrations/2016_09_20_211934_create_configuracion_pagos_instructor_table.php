<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionPagosInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('configuracion_pagos_instructor', function(Blueprint $table)
        {
            $table->increments('id');         

            $table->integer('clase_grupal_id')->unsigned()->nullable();
            $table->foreign('clase_grupal_id')->references('id')->on('clases_grupales');
            $table->integer('instructor_id')->unsigned()->nullable();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->double('monto');

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
        Schema::drop('configuracion_pagos_instructor');
    }

}
