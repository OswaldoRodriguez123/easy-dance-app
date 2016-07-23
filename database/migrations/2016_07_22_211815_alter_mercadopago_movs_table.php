<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMercadopagoMovsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mercadopago_movs', function (Blueprint $table) {
            $table->integer('numero_factura')->after('alumno_id');
            $table->integer('pago_id')->unique()->change();


        });        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mercadopago_movs', function (Blueprint $table) {
            $table->dropColumn('numero_factura');
            $table->dropColumn('pago_id');
        });        //
    }
}
