<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddVisitanteIdReservacionesVisitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservaciones_visitantes', function (Blueprint $table) {
            $table->integer('visitante_id')->unsigned();
            $table->foreign('visitante_id')->references('id')->on('visitantes_presenciales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservaciones_visitantes', function (Blueprint $table) {
            $table->dropColumn('visitante_id');
        });
    }
}
