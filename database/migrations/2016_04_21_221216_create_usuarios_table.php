<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
    Schema::create('usuarios', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre',50);
            $table->string('apellido',50);
            $table->string('correo');
            $table->string('telefono');
            $table->string('como_nos_conociste',30);
            $table->string('contrasena');
            
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
        Schema::drop('usuarios');
    }

}