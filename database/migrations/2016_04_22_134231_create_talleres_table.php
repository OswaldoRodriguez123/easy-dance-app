<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalleresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talleres', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',50);
            $table->string('descripcion',500);
            $table->integer('costo');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->string('link_video',30);
            $table->string('color_etiqueta',30);
            $table->tinyinteger('cupo_minimo');
            $table->tinyinteger('cupo_maximo');
            $table->tinyinteger('cupo_reservacion');
            $table->string('imagen');
            $table->string('condiciones');

            $table->integer('especialidad_id')->unsigned()->nullable();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');
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
        Schema::drop('talleres');
    }

}