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
            $table->dropColumn('clase_grupal_id');
            $table->integer('instructor_id')->unsigned();

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
            
            $table->dropColumn('instructor_id');
            $table->integer('clase_grupal_id')->unsigned();
            
        });

    }
}
