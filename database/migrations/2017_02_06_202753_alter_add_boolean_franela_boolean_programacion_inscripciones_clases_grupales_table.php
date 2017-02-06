<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanFranelaBooleanProgramacionInscripcionesClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('inscripcion_clase_grupal', function (Blueprint $table) {
            $table->boolean('boolean_programacion')->default(1);
            $table->boolean('boolean_franela')->default(1);
            $table->string('razon_entrega')->nullable()->default(null);
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
            $table->dropColumn('boolean_programacion');
            $table->dropColumn('boolean_franela');
            $table->dropColumn('razon_entrega');
        });
    }
}
