<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddAsistenciaRojoAsistenciaAmarillaConfigClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_clases_grupales', function (Blueprint $table) {
            
            $table->integer('asistencia_rojo');
            $table->integer('asistencia_amarilla');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_clases_grupales', function (Blueprint $table) {
            $table->dropColumn('asistencia_rojo');
            $table->dropColumn('asistencia_amarilla');
        });
    }
}
