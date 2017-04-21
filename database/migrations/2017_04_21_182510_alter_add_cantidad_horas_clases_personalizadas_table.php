<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddCantidadHorasClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_personalizadas', function (Blueprint $table) {
            $table->integer('cantidad_horas');
        });

        Schema::table('inscripcion_clase_personalizada', function (Blueprint $table) {
            $table->integer('cantidad_horas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clases_personalizadas', function (Blueprint $table) {
            $table->dropColumn('cantidad_horas');
        });

        Schema::table('inscripcion_clase_personalizada', function (Blueprint $table) {
            $table->dropColumn('cantidad_horas');
        });
    }
}
