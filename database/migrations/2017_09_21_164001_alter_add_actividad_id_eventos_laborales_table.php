<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddActividadIdEventosLaboralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventos_laborales', function (Blueprint $table) {
            $table->integer('actividad_id')->unsigned()->nullable()->default(null);
            $table->foreign('actividad_id')->references('id')->on('actividades_laborales');
            $table->dropColumn('nombre');
            $table->dropColumn('descripcion');
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
            $table->dropForeign('eventos_laborales_actividad_id_foreign');
            $table->dropColumn('actividad_id');
            $table->string('nombre');
            $table->string('descripcion');
        });
    }
}
