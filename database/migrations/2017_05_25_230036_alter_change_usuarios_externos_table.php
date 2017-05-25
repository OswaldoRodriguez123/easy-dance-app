<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeUsuariosExternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_externos', function (Blueprint $table) {
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
        Schema::table('usuario_externos', function (Blueprint $table) {
            $table->renameColumn('tipo_evento_id', 'campana_id');
            $table->dropColumn('tipo_evento');
        });
    }
}
