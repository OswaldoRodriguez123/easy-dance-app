<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoPromotorItemsFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->integer('tipo_promotor')->default(1);
        });

        Schema::table('items_factura', function (Blueprint $table) {
            $table->integer('tipo_promotor')->default(1);
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
            $table->dropColumn('tipo_promotor');
        });

        Schema::table('items_factura', function (Blueprint $table) {
            $table->dropColumn('tipo_promotor');
        });
    }
}
