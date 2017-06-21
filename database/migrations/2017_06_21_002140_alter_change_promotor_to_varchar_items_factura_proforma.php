<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangePromotorToVarcharItemsFacturaProforma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->string('tipo_promotor')->change();
            $table->string('promotor_id')->change();
        });

        Schema::table('items_factura', function (Blueprint $table) {
            $table->string('tipo_promotor')->change();
            $table->string('promotor_id')->change();
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
            $table->integer('tipo_promotor')->change();
            $table->integer('promotor_id')->change();
        });

        Schema::table('items_factura', function (Blueprint $table) {
            $table->integer('tipo_promotor')->change();
            $table->integer('promotor_id')->change();
        });
    }
}
