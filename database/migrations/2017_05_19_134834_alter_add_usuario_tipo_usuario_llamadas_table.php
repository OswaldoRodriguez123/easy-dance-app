<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddUsuarioTipoUsuarioLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('llamadas', function (Blueprint $table) {
            $table->dropForeign('llamadas_visitante_id_foreign');
            $table->renameColumn('visitante_id', 'usuario_id');
            $table->integer('usuario_tipo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('llamadas', function (Blueprint $table) {
             // $table->foreign('visitante_id')->references('id')->on('visitantes_presenciales');
            $table->renameColumn('usuario_id', 'visitante_id');
            $table->dropColumn('usuario_tipo');
        });
    }
}
