<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('llamadas', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('visitante_id')->unsigned();
            $table->foreign('visitante_id')->references('id')->on('visitantes_presenciales');

            $table->tinyinteger('status');
            $table->string('observacion', 255);

            $table->date('fecha_llamada');
            $table->time('hora_llamada');
            $table->date('fecha_siguiente');
            $table->time('hora_siguiente');

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
        Schema::drop('llamadas');
    }

}

