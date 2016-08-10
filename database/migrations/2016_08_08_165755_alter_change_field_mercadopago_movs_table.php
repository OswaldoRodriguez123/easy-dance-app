<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeFieldMercadopagoMovsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mercadopago_movs', function (Blueprint $table) {
            $table->string('preference_id')->change();
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
            $table->integer('preference_id')->change();
        });
    }
}
