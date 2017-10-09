<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('telefono');
            $table->string('celular');
            $table->string('sexo');
            $table->integer('como_nos_conociste_id')->unsigned();
            $table->foreign('como_nos_conociste_id')->references('id')->on('config_como_nos_conociste');
            $table->string('direccion');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('linkedin');
            $table->string('instagram');
            $table->string('pagina_web');
            $table->string('youtube');
            $table->string('imagen');
            $table->string('email');
            $table->string('password');

            $table->rememberToken();
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
        Schema::drop('users');
    }
}
