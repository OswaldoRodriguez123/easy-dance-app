<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewCoreografiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coreografias', function(Blueprint $table){
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('fiesta_id')->unsigned();
            $table->foreign('fiesta_id')->references('id')->on('fiestas');
            $table->string('nombre_coreografia');
            $table->integer('tipo');
            $table->string('imagen');
            $table->string('descripcion');
            $table->string('link_video');
            $table->string('imagen_presentacion');
            $table->string('especialidad_id');
            $table->string('tema_musical');
            $table->string('tiempo_duracion');
            $table->integer('instructor_id')->unsigned();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->boolean('boolean_promocionar')->default(1);
            $table->string('color_etiqueta');

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
        Schema::drop('coreografias');
    }
}
