<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::create('visitantes_presenciales', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('identificacion',20)->unique();
            $table->string('nombre',15);
            $table->string('apellido',15);
            $table->date('fecha_nacimiento');
            $table->string('sexo',15);
            $table->string('correo',30)->unique();
            $table->string('telefono',11);
            $table->string('celular',11);
            $table->integer('como_nos_conociste_id')->unsigned();
            $table->foreign('como_nos_conociste_id')->references('id')->on('config_como_nos_conociste');
            $table->integer('dias_clase_id')->unsigned();
            $table->foreign('dias_clase_id')->references('id')->on('dias_de_interes');
            $table->integer('especialidad_id')->unsigned();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');
            $table->date('fecha_registro');
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
        Schema::drop('visitantes_presenciales');
    }

}
