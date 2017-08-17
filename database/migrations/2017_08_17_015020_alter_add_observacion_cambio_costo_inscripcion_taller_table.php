<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddObservacionCambioCostoInscripcionTallerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscripcion_taller', function (Blueprint $table) {
            $table->string('observacion_cambio_costo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscripcion_taller', function (Blueprint $table) {
            $table->dropColumn('observacion_cambio_costo');
        });
    }
}

