<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRenameSupervisionEvaluacionToSupervisionesEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('supervision_evaluacion', 'supervisiones_evaluaciones');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('supervisiones_evaluaciones', 'supervision_evaluacion');
    }
}
