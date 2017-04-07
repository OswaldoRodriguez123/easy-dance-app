<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddInstructorInscripcionClaseGrupalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::table('inscripcion_clase_grupal', function (Blueprint $table) {
            $table->integer('instructor_id')->unsigned()->nullable()->default(null);
            $table->foreign('instructor_id')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inscripcion_clase_grupal', function (Blueprint $table) {
            $table->dropForeign('inscripcion_clase_grupal_instructor_id_foreign');
            $table->dropColumn('instructor_id');
        });
    }
}
