<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeTransferenciasCampanasToTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('transferencias_campana', function (Blueprint $table) {
            $table->dropForeign('transferencias_campana_campana_id_foreign');
            $table->renameColumn('campana_id', 'tipo_evento_id');
            $table->integer('tipo_evento')->default(1);
        });

        Schema::rename('transferencias_campana', 'patrocinadores_proforma');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('patrocinadores_proforma', function (Blueprint $table) {
            $table->renameColumn('tipo_evento_id', 'campana_id');
            $table->dropColumn('tipo_evento');
        });

        Schema::rename('patrocinadores_proforma', 'transferencias_campana');

    }
}
