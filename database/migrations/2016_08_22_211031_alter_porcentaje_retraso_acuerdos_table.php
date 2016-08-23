<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPorcentajeRetrasoAcuerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acuerdos', function(Blueprint $table)
        {
            $table->integer('porcentaje_retraso');
            $table->integer('tiempo_tolerancia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        chema::table('acuerdos', function(Blueprint $table)
        {
            $table->dropColumn('porcentaje_retraso');
            $table->dropColumn('tiempo_tolerancia');
        });
        
    }
}
