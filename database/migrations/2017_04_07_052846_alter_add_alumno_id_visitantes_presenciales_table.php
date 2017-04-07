<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddAlumnoIdVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->integer('alumno_id')->unsigned()->nullable()->default(null);
            $table->foreign('alumno_id')->references('id')->on('alumnos');
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
            $table->dropForeign('visitantes_presenciales_alumno_id_foreign');
            $table->dropColumn('alumno_id');
        });
    }
}
