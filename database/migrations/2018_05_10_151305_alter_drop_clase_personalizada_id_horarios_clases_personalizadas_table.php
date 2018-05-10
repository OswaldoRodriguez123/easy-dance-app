<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropClasePersonalizadaIdHorariosClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('horarios_clases_personalizadas', function (Blueprint $table) {
            $table->dropForeign('horarios_clases_personalizadas_clase_personalizada_id_foreign');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('horarios_clases_personalizadas', function (Blueprint $table) {
            $table->foreign('clase_personalizada_id')->references('id')->on('inscripcion_clase_personalizada');
        });
    }
}
