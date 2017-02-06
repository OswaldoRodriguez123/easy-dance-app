<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddEstatusRazonCancelacionCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('citas', function (Blueprint $table) {
            $table->boolean('estatus')->default(1);
            $table->boolean('boolean_mostrar')->default(1);
            $table->string('razon_cancelacion')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn('estatus');
            $table->dropColumn('boolean_mostrar');
            $table->dropColumn('razon_cancelacion');
        });
    }
}
