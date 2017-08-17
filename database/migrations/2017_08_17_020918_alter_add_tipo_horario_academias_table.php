<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoHorarioAcademiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academias', function (Blueprint $table) {
            $table->tinyinteger('tipo_horario')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academias', function (Blueprint $table) {
            $table->dropColumn('tipo_horario');
        });
    }
}
