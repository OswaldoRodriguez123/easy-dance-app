<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddColorEtiquetaMultihorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horario_clase_grupales', function (Blueprint $table) {
            
            $table->string('color_etiqueta');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('horario_clase_grupales', function (Blueprint $table) {
            
            $table->dropColumn('color_etiqueta');
            
        });

    }
}
