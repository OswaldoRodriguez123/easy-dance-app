<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoConfigServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_servicios', function (Blueprint $table) {
            
            $table->tinyinteger('tipo')->default(1);

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
            
            $table->dropColumn('tipo');
            
        });

    }
}
