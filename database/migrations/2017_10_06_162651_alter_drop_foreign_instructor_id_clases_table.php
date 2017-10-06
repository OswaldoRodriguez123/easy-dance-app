<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropForeignInstructorIdClasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->dropForeign('clases_grupales_instructor_id_foreign');
        });

        Schema::table('horarios_clases_grupales', function (Blueprint $table) {
            $table->dropForeign('horario_clase_grupales_instructor_id_foreign');
        });

        Schema::table('talleres', function (Blueprint $table) {
            $table->dropForeign('talleres_instructor_id_foreign');
        });

        Schema::table('horarios_talleres', function (Blueprint $table) {
            $table->dropForeign('horarios_talleres_instructor_id_foreign');
        });

        Schema::table('inscripcion_clase_personalizada', function (Blueprint $table) {
            $table->dropForeign('inscripcion_clase_personalizada_instructor_id_foreign');
        });

        Schema::table('horarios_clases_personalizadas', function (Blueprint $table) {
            $table->dropForeign('horarios_clases_personalizadas_instructor_id_foreign');
        });

        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign('citas_instructor_id_foreign');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('clases_grupales', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructores');
        });

        Schema::table('horarios_clases_grupales', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructores');
        });

        Schema::table('talleres', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructores');
        });

        Schema::table('horarios_talleres', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructores');
        });

        Schema::table('inscripcion_clase_personalizada', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructores');
        });

        Schema::table('horarios_clases_personalizadas', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructores');
        });

        Schema::table('citas', function (Blueprint $table) {
            $table->foreign('instructor_id')->references('id')->on('instructores');
        });
    }
}
