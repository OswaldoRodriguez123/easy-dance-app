<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanCredencialAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->integer('boolean_credencial')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropColumn('boolean_credencial');
        });
    }
}
