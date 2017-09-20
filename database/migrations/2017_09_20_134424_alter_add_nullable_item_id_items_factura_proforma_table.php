<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddNullableItemIdItemsFacturaProformaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_factura_proforma', function (Blueprint $table) {

            $table->integer('item_id')->nullable()->change();
   
        });

        Schema::table('items_factura', function (Blueprint $table) {

            $table->integer('item_id')->nullable()->change();
   
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

            $table->integer('item_id')->change();
            
        });

        Schema::table('items_factura', function (Blueprint $table) {

            $table->integer('item_id')->change();
            
        });

    }
}

