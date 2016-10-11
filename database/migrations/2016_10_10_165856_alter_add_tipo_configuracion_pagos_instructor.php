<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoConfiguracionPagosInstructor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configuracion_pagos_instructor', function (Blueprint $table) {
            
            $table->tinyinteger('tipo')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('configuracion_pagos_instructor', function (Blueprint $table) {
            
            $table->dropColumn('tipo');
            
        });

    }
}
