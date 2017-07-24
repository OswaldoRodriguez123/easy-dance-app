<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddDatosVencimientoCredencialesAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credenciales_alumno', function (Blueprint $table) {
            $table->boolean('boolean_uso')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credenciales_alumno', function (Blueprint $table) {
            $table->dropColumn('boolean_uso');
        });
    }
}
