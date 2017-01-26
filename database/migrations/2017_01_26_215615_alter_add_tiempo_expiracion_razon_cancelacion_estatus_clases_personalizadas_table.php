<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTiempoExpiracionRazonCancelacionEstatusClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('clases_personalizadas', function (Blueprint $table) {
            $table->boolean('estatus')->default(1);
            $table->string('razon_cancelacion')->nullable()->default(null);
            $table->integer('tiempo_expiracion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clases_personalizadas', function (Blueprint $table) {
            $table->dropColumn('estatus');
            $table->dropColumn('razon_cancelacion');
            $table->dropColumn('tiempo_expiracion');
        });
    }
}
