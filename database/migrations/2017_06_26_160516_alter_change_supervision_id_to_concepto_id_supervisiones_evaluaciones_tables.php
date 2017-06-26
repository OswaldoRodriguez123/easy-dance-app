<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeSupervisionIdToConceptoIdSupervisionesEvaluacionesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supervisiones_evaluaciones', function (Blueprint $table) {
            $table->dropForeign('supervision_evaluacion_supervision_id_foreign');
            $table->renameColumn('supervision_id', 'concepto_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supervisiones_evaluaciones', function (Blueprint $table) {
            $table->renameColumn('concepto_id', 'supervision_id');
        });

    }
}
