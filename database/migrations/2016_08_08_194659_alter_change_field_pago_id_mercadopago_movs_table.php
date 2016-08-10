<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeFieldPagoIdMercadopagoMovsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mercadopago_movs', function (Blueprint $table) {
            $table->string('pago_id',20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mercadopago_movs', function (Blueprint $table) {
            $table->integer('pago_id')->change();
        });
    }
}
