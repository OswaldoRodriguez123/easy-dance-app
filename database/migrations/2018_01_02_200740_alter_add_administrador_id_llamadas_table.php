<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddAdministradorIdLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('llamadas', function (Blueprint $table) {
            $table->integer('administrador_id');
        });

        Schema::table('llamadas_visitantes', function (Blueprint $table) {
            $table->integer('administrador_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('llamadas', function (Blueprint $table) {
            $table->dropColumn('administrador_id');
        });

        Schema::table('llamadas_visitantes', function (Blueprint $table) {
            $table->dropColumn('administrador_id');
        });
    }
}
