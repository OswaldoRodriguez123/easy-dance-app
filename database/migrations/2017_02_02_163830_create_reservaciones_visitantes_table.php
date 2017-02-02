<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionesVisitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('reservaciones_visitantes', function(Blueprint $table)
        {
            $table->increments('id'); 

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('visitante_id')->unsigned();
            $table->foreign('visitante_id')->references('id')->on('visitantes_presenciales');
            $table->integer('tipo_reservacion')->unsigned();
            $table->integer('tipo_id')->unsigned();
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
        Schema::drop('reservaciones_visitantes');
    }
}
