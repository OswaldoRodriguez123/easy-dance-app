<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddRazonCongelacionInscripcionClaseGrupalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('inscripcion_clase_grupal', function (Blueprint $table) {
            $table->string('razon_congelacion')->nullable()->default(null);
            $table->date('fecha_inicio');
            $table->date('fecha_final');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscripcion_clase_grupal', function (Blueprint $table) {
            $table->dropColumn('razon_congelacion');
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_final');
        });
    }
}
