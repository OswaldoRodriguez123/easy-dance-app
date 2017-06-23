<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeForeignTablesSupervisionesTable extends Migration
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
            $table->foreign('supervision_id')->references('id')->on('config_supervisiones_evaluaciones');

        });

        Schema::table('supervision_evaluacion', function (Blueprint $table) {
            $table->dropForeign('supervision_evaluacion_supervision_id_foreign');
            $table->foreign('supervision_id')->references('id')->on('config_supervisiones_evaluaciones');

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
            $table->dropForeign('horarios_supervision_supervision_id_foreign');
            $table->foreign('supervision_id')->references('id')->on('supervisiones');

        });

        Schema::table('supervision_evaluacion', function (Blueprint $table) {
            $table->dropForeign('supervision_evaluacion_supervision_id_foreign');
            $table->foreign('supervision_id')->references('id')->on('supervisiones');

        });
    }
}
