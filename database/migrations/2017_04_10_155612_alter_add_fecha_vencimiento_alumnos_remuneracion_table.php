<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddFechaVencimientoAlumnosRemuneracionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('alumnos_remuneracion', function (Blueprint $table) {
            
            $table->date('fecha_vencimiento');
            $table->string('concepto');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos_remuneracion', function (Blueprint $table) {
            
            $table->dropColumn('fecha_vencimiento');
            $table->dropColumn('concepto');
            
        });
    }
}
