<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRenameConfigSupervisionEvaluacionToConceptoSupervision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('config_supervisiones_evaluaciones', 'conceptos_supervisiones');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('conceptos_supervisiones', 'config_supervisiones_evaluaciones');
    }
}
