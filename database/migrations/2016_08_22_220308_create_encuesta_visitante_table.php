<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaVisitanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuesta_visitante', function(Blueprint $table)
        {
            $table->increments('id');  
            $table->integer('visitante_id')->unsigned();
            $table->foreign('visitante_id')->references('id')->on('visitantes_presenciales');         

            $table->tinyinteger('rapidez');
            $table->tinyinteger('calidad');
            $table->tinyinteger('satisfaccion');
            $table->tinyinteger('disponibilidad');

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
        Schema::drop('encuesta_visitante');
    }

}
