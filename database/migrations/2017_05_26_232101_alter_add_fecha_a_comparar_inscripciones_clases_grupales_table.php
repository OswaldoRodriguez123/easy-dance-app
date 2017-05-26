<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddFechaACompararInscripcionesClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscripcion_clase_grupal', function (Blueprint $table) {
            $table->date('fecha_a_comprobar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscripcion_clase_grupal', function (Blueprint $table) {
            $table->dropColumn('fecha_a_comprobar');
        });
    }
}
