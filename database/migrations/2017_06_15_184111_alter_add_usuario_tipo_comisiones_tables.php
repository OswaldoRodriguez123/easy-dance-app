<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddUsuarioTipoComisionesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comisiones', function (Blueprint $table) {
            $table->integer('usuario_tipo')->default(1);
        });

        Schema::table('config_comisiones', function (Blueprint $table) {
            $table->integer('usuario_tipo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comisiones', function (Blueprint $table) {
            $table->dropColumn('usuario_tipo');
        });

        Schema::table('config_comisiones', function (Blueprint $table) {
            $table->dropColumn('usuario_tipo');
        });
    }
}
