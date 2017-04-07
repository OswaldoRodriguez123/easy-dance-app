<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddInstructorIdInscripcionClasePersonalizadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inscripcion_clase_personalizada', function (Blueprint $table) {
            $table->integer('promotor_id')->unsigned()->nullable()->default(null);
            $table->foreign('promotor_id')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscripcion_clase_personalizada', function (Blueprint $table) {
            $table->dropForeign('inscripcion_clase_personalizada_promotor_id_foreign');
            $table->dropColumn('promotor_id');
        });
    }
}
