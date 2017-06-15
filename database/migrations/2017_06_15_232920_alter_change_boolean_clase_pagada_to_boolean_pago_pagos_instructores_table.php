<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeBooleanClasePagadaToBooleanPagoPagosInstructoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('pagos_instructor', function (Blueprint $table) {
            $table->renameColumn('boolean_clase_pagada', 'boolean_pago');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagos_instructor', function (Blueprint $table) {
            $table->renameColumn('boolean_pago', 'boolean_clase_pagada');
        });

    }
}
