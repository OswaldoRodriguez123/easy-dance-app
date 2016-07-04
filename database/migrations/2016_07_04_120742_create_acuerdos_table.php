<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcuerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acuerdos', function(Blueprint $table)
        {
            $table->increments('id');  

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');         

            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->date('fecha_inicio');
            $table->string('frecuencia');
            $table->tinyinteger('cuotas');
            $table->float('total');
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
        Schema::drop('acuerdos');
    }

}
