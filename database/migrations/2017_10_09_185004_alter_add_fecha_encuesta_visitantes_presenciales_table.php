<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddFechaEncuestaVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->date('fecha_encuesta');
            $table->time('hora_encuesta');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->dropColumn('fecha_encuesta');
            $table->dropColumn('hora_encuesta');
        });
    }
}
