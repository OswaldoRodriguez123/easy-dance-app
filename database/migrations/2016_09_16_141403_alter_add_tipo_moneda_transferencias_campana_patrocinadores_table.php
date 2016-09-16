<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoMonedaTransferenciasCampanaPatrocinadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferencias_campana', function (Blueprint $table) {
            
            $table->integer('tipo_moneda')->default(1);

        });

        Schema::table('patrocinadores', function (Blueprint $table) {
            
            $table->integer('tipo_moneda')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('transferencias_campana', function (Blueprint $table) {
            
            $table->dropColumn('tipo_moneda');
            
        });

        Schema::table('patrocinadores', function (Blueprint $table) {
            
            $table->dropColumn('tipo_moneda');
            
        });

    }
}
