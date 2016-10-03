<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencias', function (Blueprint $table) {
            
            $table->tinyinteger('tipo')->default(1);
            $table->integer('tipo_id')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('asistencias', function (Blueprint $table) {
            
            $table->dropColumn('tipo');
            $table->dropColumn('tipo_id');
            
        });

    }
}