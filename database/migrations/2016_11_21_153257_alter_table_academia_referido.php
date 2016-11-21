<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAcademiaReferido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academias', function (Blueprint $table) {
            
            $table->integer('puntos_referidos');
            $table->integer('puntos_referencia');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            
            $table->dropColumn('puntos_referidos');
            $table->dropColumn('puntos_referencia');

        });
    }
}
