<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddDiasRecompraAcademiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('academias', function (Blueprint $table) {
            $table->integer('dias_recompra');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academias', function (Blueprint $table) {
            $table->dropColumn('dias_recompra');
        });
    }
}
