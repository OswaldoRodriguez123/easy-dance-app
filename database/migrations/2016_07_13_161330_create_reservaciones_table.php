<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('reservaciones', function(Blueprint $table)
        {
            $table->increments('id'); 

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('tipo_reservacion')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->string('nombre');
            $table->string('telefono');   
            $table->string('sexo',1);
            $table->string('correo');

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
        Schema::drop('reservaciones');
    }
}
