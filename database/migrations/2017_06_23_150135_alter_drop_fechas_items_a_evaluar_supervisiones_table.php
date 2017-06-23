<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropFechasItemsAEvaluarSupervisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supervisiones', function(Blueprint $table)
        {
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_final');
            $table->dropColumn('items_a_evaluar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supervisiones', function(Blueprint $table)
        {
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->string('items_a_evaluar');
        });
    }
}
