<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanAlumnoAceptacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('inscripcion_clase_personalizada', function (Blueprint $table) {
            $table->boolean('boolean_alumno_aceptacion')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscripcion_clase_personalizada', function (Blueprint $table) {
            $table->dropColumn('boolean_alumno_aceptacion');
        });
    }
}
