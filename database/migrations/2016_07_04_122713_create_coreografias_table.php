<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreografiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('coreografias', function(Blueprint $table)
        {
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