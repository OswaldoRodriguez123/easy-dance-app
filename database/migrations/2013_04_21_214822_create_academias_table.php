<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('academias', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('sucursal_id')->unsigned()->nullable();
            $table->foreign('sucursal_id')->references('id')->on('sucursales');

            $table->string('nombre');

            $table->integer('especialidades_id')->unsigned()->nullable();
            $table->foreign('especialidades_id')->references('id')->on('config_especialidades');

            $table->integer('pais_id')->unsigned()->nullable();
            $table->foreign('pais_id')->references('id')->on('paises');

            $table->string('estado');
            $table->string('identificacion',20);
            $table->string('imagen')->nullable();
            $table->string('descripcion');
            $table->string('telefono');
            $table->string('celular');
            $table->string('correo');
            $table->string('direccion');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('linkedin');
            $table->string('instagram');
            $table->string('pagina_web');
            $table->string('youtube');
            $table->string('normativa');
            $table->string('manual');
            $table->string('programacion');
            $table->tinyinteger('status_amarillo');
            $table->tinyinteger('status_rojo');
            $table->tinyinteger('incluye_iva');
            $table->tinyinteger('porcentaje_impuesto');
            $table->integer('numero_factura');
            $table->string('moneda');
            $table->string('link_video');
            $table->date('fecha_comprobacion');

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
        Schema::drop('academias');
    }

}
