<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropForeignItemsFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->dropForeign('items_factura_proforma_promotor_id_foreign');
        });

        Schema::table('items_factura', function (Blueprint $table) {
            $table->dropForeign('items_factura_promotor_id_foreign');
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
            $table->foreign('promotor_id')->references('id')->on('staff');
        });

        Schema::table('items_factura', function (Blueprint $table) {
            $table->foreign('promotor_id')->references('id')->on('staff');
        });
    }
}
