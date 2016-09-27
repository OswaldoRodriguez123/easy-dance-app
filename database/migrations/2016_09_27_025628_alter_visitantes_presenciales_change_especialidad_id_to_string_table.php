<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVisitantesPresencialesChangeEspecialidadIdToStringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            
            $table->string('especialidad_id')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            
            $table->integer('especialidad_id')->change();
            
        });

    }
}
