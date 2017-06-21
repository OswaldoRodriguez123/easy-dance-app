<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddConfigSupervisionIdConfigSupervisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_supervision', function (Blueprint $table) {
            $table->integer('config_supervision_id')->unsigned()->nullable()->default(null);
            $table->foreign('config_supervision_id')->references('id')->on('configuracion_supervisiones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_supervision', function (Blueprint $table) {
            $table->dropForeign('config_supervision_config_supervision_id_foreign');
            $table->dropColumn('config_supervision_id');
        });
    }
}
