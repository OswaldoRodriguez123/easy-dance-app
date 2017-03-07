<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeClaseGrupalIdToInstructorIdCredencialesAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credenciales_alumno', function (Blueprint $table) {
            $table->dropForeign('credenciales_alumno_clase_grupal_id_foreign');
            $table->dropColumn('clase_grupal_id');

            $table->integer('instructor_id')->unsigned();
            $table->foreign('instructor_id')->references('id')->on('instructores');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('credenciales_alumno', function (Blueprint $table) {
            
            $table->dropForeign('credenciales_alumno_instructor_id_foreign');
            $table->dropColumn('instructor_id');

            $table->integer('clase_grupal_id')->unsigned();
            $table->foreign('clase_grupal_id')->references('id')->on('clases_grupales');
            
        });

    }
}
