<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('academia_id')->unsigned()->nullable();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre');    
            $table->integer('especialidad_id')->unsigned()->nullable();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');
            $table->integer('nivel_id')->unsigned()->nullable();
            $table->foreign('nivel_id')->references('id')->on('config_niveles_baile');
            $table->integer('ciclo')->unsigned()->nullable();
            $table->string('link_video');
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
        Schema::drop('pasos');
    }
}