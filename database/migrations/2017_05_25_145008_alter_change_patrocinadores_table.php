<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangePatrocinadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patrocinadores', function (Blueprint $table) {
            $table->dropForeign('patrocinadores_campana_id_foreign');
            $table->renameColumn('campana_id', 'tipo_evento_id');
            $table->integer('tipo_evento')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patrocinadores', function (Blueprint $table) {
             // $table->foreign('visitante_id')->references('id')->on('visitantes_presenciales');
            $table->renameColumn('tipo_evento_id', 'campana_id');
            $table->dropColumn('tipo_evento');
        });
    }
}
