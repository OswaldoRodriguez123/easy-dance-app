<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddFechaSiguienteHoraSiguienteLlamadasAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('llamadas', function (Blueprint $table) {
            $table->date('fecha_siguiente');
            $table->time('hora_siguiente');
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
            $table->dropColumn('fecha_siguiente');
            $table->dropColumn('hora_siguiente');
        });
    }
}
