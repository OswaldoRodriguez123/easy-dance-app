<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlumnosRemuneracion extends Migration
{
    public function up()
    {
        Schema::create('alumnos_remuneracion', function(Blueprint $table)
        {
            $table->increments('id');  
            $table->integer('alumno_id');
            $table->integer('remuneracion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('alumnos_remuneracion');
    }
}
