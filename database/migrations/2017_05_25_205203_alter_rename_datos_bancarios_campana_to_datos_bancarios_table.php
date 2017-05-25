<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRenameDatosBancariosCampanaToDatosBancariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('datos_bancarios_campana', function (Blueprint $table) {
            $table->dropForeign('datos_bancarios_campana_campana_id_foreign');
            $table->renameColumn('campana_id', 'tipo_evento_id');
            $table->integer('tipo_evento')->default(1);
        });

        Schema::rename('datos_bancarios_campana', 'datos_bancarios');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('datos_bancarios', function (Blueprint $table) {
            $table->renameColumn('tipo_evento_id', 'campana_id');
            $table->dropColumn('tipo_evento');
        });

        Schema::rename('datos_bancarios', 'datos_bancarios_campana');

    }
}
