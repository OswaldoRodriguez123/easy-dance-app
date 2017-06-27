<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddMontoMinimoConfigComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_comisiones', function (Blueprint $table) {
            $table->double('monto_minimo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_comisiones', function (Blueprint $table) {
            $table->dropColumn('monto_minimo');
        });
    }
}
