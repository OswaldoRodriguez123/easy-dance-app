<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddServicioProductoTipoServicioProductoIdComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('comisiones', function (Blueprint $table) {
            $table->dropForeign('pagos_staff_servicio_id_foreign');
            $table->renameColumn('servicio_id', 'servicio_producto_id');
            $table->integer('servicio_producto_tipo')->default(1);
        });

        Schema::table('config_comisiones', function (Blueprint $table) {
            $table->dropForeign('config_pagos_staff_servicio_id_foreign');
            $table->renameColumn('servicio_id', 'servicio_producto_id');
            $table->integer('servicio_producto_tipo')->default(1);
            $table->dropColumn('tipo_servicio');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('comisiones', function (Blueprint $table) {
            $table->renameColumn('servicio_producto_id', 'servicio_id');
            $table->dropColumn('servicio_producto_tipo');
        });

        Schema::table('config_comisiones', function (Blueprint $table) {
            $table->renameColumn('servicio_producto_id', 'servicio_id');
            $table->dropColumn('servicio_producto_tipo');
            $table->integer('tipo_servicio');
        });

    }
}
