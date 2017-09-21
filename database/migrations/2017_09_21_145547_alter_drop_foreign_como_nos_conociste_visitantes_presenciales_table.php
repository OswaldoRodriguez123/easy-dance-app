<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropForeignComoNosConocisteVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->dropForeign('visitantes_presenciales_como_nos_conociste_id_foreign');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->foreign('como_nos_conociste_id')->references('id')->on('config_como_nos_conociste');
        });
    }
}
