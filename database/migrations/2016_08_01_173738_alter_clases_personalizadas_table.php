<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_personalizadas', function (Blueprint $table) {
            
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_final');
            $table->dropColumn('hora_inicio');
            $table->dropColumn('hora_final');

            $table->dropForeign('clases_personalizadas_alumno_id_foreign');
            $table->dropColumn('alumno_id');

            $table->dropForeign('clases_personalizadas_especialidad_id_foreign');
            $table->dropColumn('especialidad_id');

            $table->dropForeign('clases_personalizadas_instructor_id_foreign');
            $table->dropColumn('instructor_id');

            $table->dropForeign('clases_personalizadas_estudio_id_foreign');
            $table->dropColumn('estudio_id');

            //$table->dropColumn('estatus');
            //$table->dropColumn('razon_cancelacion');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('clases_personalizadas', function (Blueprint $table) {
            
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->time('hora_inicio');
            $table->time('hora_final');

            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');

            $table->integer('especialidad_id')->unsigned();
            $table->foreign('especialidad_id')->references('id')->on('config_especialidades');

            $table->integer('instructor_id')->unsigned();
            $table->foreign('instructor_id')->references('id')->on('instructores');

            $table->integer('estudio_id')->unsigned();
            $table->foreign('estudio_id')->references('id')->on('config_estudios');

            //$table->boolean('estatus')->default(1);
            //$table->string('razon_cancelacion')->nullable()->default(null);
            
        });

    }
}
