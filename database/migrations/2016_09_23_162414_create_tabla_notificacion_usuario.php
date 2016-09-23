<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaNotificacionUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion_usuario', function(Blueprint $table)
        {
            $table->increments('id');  
            $table->integer('id_usuario');
            $table->integer('id_notificacion');
            $table->boolean('visto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('notificacion_usuario', function(Blueprint $table)
        {
            $table->drop('notificacion_usuario');
        });
    }
}
