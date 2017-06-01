<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanPagadoItemsAcuerdoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_acuerdo', function (Blueprint $table) {
            $table->integer('boolean_pagado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items_acuerdo', function (Blueprint $table) {
            $table->dropColumn('boolean_pagado');
        });
    }
}