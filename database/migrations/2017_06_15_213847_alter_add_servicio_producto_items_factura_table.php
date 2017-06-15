<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddServicioProductoItemsFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->integer('servicio_producto')->default(1);
        });

        Schema::table('items_factura', function (Blueprint $table) {
            $table->integer('servicio_producto')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->dropColumn('servicio_producto');
        });

        Schema::table('items_factura', function (Blueprint $table) {
            $table->dropColumn('servicio_producto');
        });
    }
}
