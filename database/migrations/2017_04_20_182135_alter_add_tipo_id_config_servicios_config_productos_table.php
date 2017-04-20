<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoIdConfigServiciosConfigProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_servicios', function (Blueprint $table) {
            
            $table->integer('tipo_id')->nullable()->default(null);

        });

        Schema::table('config_productos', function (Blueprint $table) {
            
            $table->integer('tipo_id')->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('config_servicios', function (Blueprint $table) {
            
            $table->dropColumn('tipo_id');
            
        });

        Schema::table('config_productos', function (Blueprint $table) {
            
            $table->dropColumn('tipo_id');
            
        });

    }
}
