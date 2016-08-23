<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDescripcionesAgendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_clases_grupales', function (Blueprint $table) {

            $table->string('descripcion', 10000)->change();
            
        });

        Schema::table('talleres', function (Blueprint $table) {

            $table->string('descripcion', 10000)->change();
            
        });

        Schema::table('fiestas', function (Blueprint $table) {

            $table->string('descripcion', 10000)->change();
            
        });

        Schema::table('clases_personalizadas', function (Blueprint $table) {

            $table->string('descripcion', 10000)->change();
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_clases_grupales', function (Blueprint $table) {

            $table->string('descripcion', 1000)->change();
            
        });

        Schema::table('talleres', function (Blueprint $table) {

            $table->string('descripcion', 1000)->change();
            
        });

        Schema::table('fiestas', function (Blueprint $table) {

            $table->string('descripcion', 1000)->change();
            
        });

        Schema::table('clases_personalizadas', function (Blueprint $table) {

            $table->string('descripcion', 1000)->change();
            
        });
    }
}
