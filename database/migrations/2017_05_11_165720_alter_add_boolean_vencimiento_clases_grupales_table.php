<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanVencimientoClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->integer('boolean_vencimiento')->default(0);
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
            $table->dropColumn('boolean_vencimiento');
        });
    }
}

