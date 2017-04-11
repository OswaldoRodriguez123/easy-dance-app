<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddEstatusHorariosClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horarios_clases_personalizadas', function (Blueprint $table) {
            
            $table->integer('estatus')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('horarios_clases_personalizadas', function (Blueprint $table) {
            
            $table->dropColumn('estatus');
            
        });

    }
}
