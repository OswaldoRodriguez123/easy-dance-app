<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferenciasCampanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias_campana', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('campana_id')->unsigned();
            $table->foreign('campana_id')->references('id')->on('campanas');
            $table->string('nombre');
            $table->string('nombre_banco');
            $table->string('tipo_cuenta');
            $table->string('numero_cuenta');
            $table->string('rif');
            $table->string('correo');
            $table->double('monto');
            $table->boolean('status')->default(0);
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
        Schema::drop('transferencias_campana');
    }

}
