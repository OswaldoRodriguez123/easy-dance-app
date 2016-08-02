<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigProductosServiciosNombreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_productos', function (Blueprint $table) {

            $table->string('nombre')->change();
            
        });

        Schema::table('config_servicios', function (Blueprint $table) {

            $table->string('nombre')->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_productos', function (Blueprint $table) {

            $table->string('nombre',15)->change();
            
        });

        Schema::table('config_servicios', function (Blueprint $table) {

            $table->string('nombre',15)->change();
            
        });
    }
}
