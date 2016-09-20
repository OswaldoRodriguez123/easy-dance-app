<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddDiasProrrogaClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            
            $table->integer('dias_prorroga');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('clases_grupales', function (Blueprint $table) {
            
            $table->dropColumn('dias_prorroga');
            
        });

    }
}
