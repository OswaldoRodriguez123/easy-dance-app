<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddMontoBooleanClasePagadaAsistenciasInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencias_instructor', function (Blueprint $table) {
            
            $table->double('monto');
            $table->boolean('boolean_clase_pagada')->default(0);


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('asistencias_instructor', function (Blueprint $table) {
            
            $table->dropColumn('monto');
            $table->dropColumn('boolean_clase_pagada');
            
        });

    }
}
