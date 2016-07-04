<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionCoreografiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_coreografia', function(Blueprint $table)
        {
            $table->increments('id');           

            $table->integer('coreografia_id')->unsigned();
            $table->foreign('coreografia_id')->references('id')->on('coreografias');
            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');

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
        Schema::drop('inscripcion_coreografia');
    }
}
