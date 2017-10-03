<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddDevolucionFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->dropColumn('usuario_id_devolucion');
            $table->dropColumn('razon_devolucion');
        });

        Schema::table('facturas', function (Blueprint $table) {
            $table->integer('usuario_id_devolucion');
            $table->string('razon_devolucion');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('usuario_id_devolucion');
            $table->dropColumn('razon_devolucion');
        });
        
        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->integer('usuario_id_devolucion');
            $table->string('razon_devolucion');
            
        });
    }
}
