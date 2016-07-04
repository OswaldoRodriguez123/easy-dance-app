<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promociones', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',50);
            $table->integer('porcentaje_descuento');
            $table->string('descripcion',500);
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->integer('edad_inicio');
            $table->integer('edad_final');
            $table->string('sexo');

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
        Schema::drop('promociones');
    }

}
