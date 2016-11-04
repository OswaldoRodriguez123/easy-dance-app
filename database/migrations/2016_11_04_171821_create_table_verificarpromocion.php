<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVerificarpromocion extends Migration
{
    public function up()
    {
        Schema::create('verificar_promocion', function(Blueprint $table)
        {
            $table->increments('id');  
            $table->integer('codigo_promocion');
            $table->integer('id_alumno');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('verificar_promocion');
    }
}
