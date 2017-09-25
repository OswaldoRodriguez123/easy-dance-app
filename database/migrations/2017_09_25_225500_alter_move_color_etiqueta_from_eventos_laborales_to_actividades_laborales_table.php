<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMoveColorEtiquetaFromEventosLaboralesToActividadesLaboralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actividades_laborales', function (Blueprint $table) {
            $table->string('color_etiqueta')->default('#de87b4');
        });

        Schema::table('eventos_laborales', function (Blueprint $table) {
            $table->dropColumn('color_etiqueta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actividades_laborales', function (Blueprint $table) {
            $table->dropColumn('color_etiqueta');
        });
        
        Schema::table('eventos_laborales', function (Blueprint $table) {
            $table->string('color_etiqueta')->default('#de87b4');
        });
    }
}
