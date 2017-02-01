<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddFormulaExitoEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluaciones', function (Blueprint $table) {
            
            $table->integer('cantidad_horas_practica');
            $table->integer('asistencia_taller');
            $table->integer('practica_horas_personalizadas');
            $table->integer('participacion_evento');
            $table->integer('participacion_fiesta_social');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('evaluaciones', function (Blueprint $table) {
            
            $table->dropColumn('cantidad_horas_practica');
            $table->dropColumn('asistencia_taller');
            $table->dropColumn('practica_horas_personalizadas');
            $table->dropColumn('participacion_evento');
            $table->dropColumn('participacion_fiesta_social');
            
        });

    }
}
