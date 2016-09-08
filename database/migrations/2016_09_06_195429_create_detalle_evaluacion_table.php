<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleEvaluacionTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_evaluacion', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('evaluacion_id')->unsigned();
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones');
            $table->string('nombre');
            $table->integer('nota');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('detalle_evaluacion');
    }
}
