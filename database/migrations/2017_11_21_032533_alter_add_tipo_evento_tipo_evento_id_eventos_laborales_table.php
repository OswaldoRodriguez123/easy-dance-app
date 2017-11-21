<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoEventoTipoEventoIdEventosLaboralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('eventos_laborales', function (Blueprint $table) {
            $table->integer('tipo_evento');
            $table->integer('tipo_evento_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventos_laborales', function (Blueprint $table) {
            $table->dropColumn('tipo_evento');
            $table->dropColumn('tipo_evento_id');
        });
    }
}
