<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddCitasClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citas_clases_personalizadas', function (Blueprint $table) {
            
            $table->integer('clase_personalizada_id')->unsigned()->nullable()->default(null);
            $table->foreign('clase_personalizada_id')->references('id')->on('clases_personalizadas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('citas_clases_personalizadas', function (Blueprint $table) {
            $table->dropForeign('citas_clases_personalizadas_clase_personalizada_id_foreign');
            $table->dropColumn('clase_personalizada_id');            
        });

    }
}
