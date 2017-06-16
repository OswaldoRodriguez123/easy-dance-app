<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddServicioIdPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            $table->integer('servicio_id')->unsigned()->nullable()->default(null);
            $table->foreign('servicio_id')->references('id')->on('config_servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            $table->dropForeign('paquetes_servicio_id_foreign');
            $table->dropColumn('servicio_id');
        });
    }
}
