<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntajes', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');   
            $table->string('nombre');
            $table->integer('cantidad');
            $table->date('fecha_vencimiento');

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
        Schema::drop('puntajes');
    }
}
