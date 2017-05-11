<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVencimientosClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vencimiento_clases_grupales', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('clase_grupal_id')->unsigned();
            $table->foreign('clase_grupal_id')->references('id')->on('clases_grupales');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
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
        Schema::drop('vencimiento_clases_grupales');
    }
}
