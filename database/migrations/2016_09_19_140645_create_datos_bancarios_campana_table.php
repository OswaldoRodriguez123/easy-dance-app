<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosBancariosCampanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_bancarios_campana', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('campana_id')->unsigned();
            $table->foreign('campana_id')->references('id')->on('campanas');
            $table->string('numero_cuenta');
            $table->string('tipo_cuenta');
            $table->string('nombre_banco');
            $table->string('rif');
            $table->string('nombre');
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
        Schema::drop('datos_bancarios_campana');
    }

}
