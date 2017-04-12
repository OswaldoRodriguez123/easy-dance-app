<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddRazonCancelacionHorariosClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('horarios_clases_personalizadas', function (Blueprint $table) {
            
            $table->string('razon_cancelacion')->nullable()->default(null);

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
            
            $table->dropColumn('razon_cancelacion');
            
        });

    }
}
