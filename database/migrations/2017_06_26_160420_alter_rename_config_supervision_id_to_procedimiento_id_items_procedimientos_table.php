<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRenameConfigSupervisionIdToProcedimientoIdItemsProcedimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_procedimientos', function (Blueprint $table) {
            $table->dropForeign('supervisiones_procedimientos_config_supervision_id_foreign');
            $table->renameColumn('config_supervision_id', 'procedimiento_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items_procedimientos', function (Blueprint $table) {
            $table->renameColumn('procedimiento_id', 'config_supervision_id');
        });

    }
}
