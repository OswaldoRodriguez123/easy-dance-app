<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeSupervisionIdToConceptoIdHorariosSupervisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horarios_supervision', function (Blueprint $table) {
            $table->dropForeign('horarios_supervision_supervision_id_foreign');
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
        Schema::table('horarios_supervision', function (Blueprint $table) {
            $table->renameColumn('concepto_id', 'supervision_id');
        });

    }
}