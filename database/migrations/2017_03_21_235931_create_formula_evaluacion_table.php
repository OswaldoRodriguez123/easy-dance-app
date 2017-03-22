<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulaEvaluacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formula_evaluacion', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('evaluacion_id')->unsigned();
            $table->foreign('evaluacion_id')->references('id')->on('evaluaciones');
            $table->string('nombre');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('formula_evaluacion');
    }
}
