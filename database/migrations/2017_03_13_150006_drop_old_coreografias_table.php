<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOldCoreografiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('inscripcion_coreografia');
        Schema::drop('coreografias');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('coreografias', function(Blueprint $table){
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre_evento',50);
            $table->string('color_etiqueta');
            $table->string('nombre_coreografia',50);
            $table->date('fecha');
            $table->integer('cantidad_minima');
            $table->integer('cantidad_maxima');
            $table->string('condiciones');
            $table->string('descripcion');
            $table->time('tiempo_duracion');

            $table->timestamps();
            $table->softDeletes();
        });

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

}
