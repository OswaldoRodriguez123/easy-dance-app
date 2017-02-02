<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddInstructorIdVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->integer('instructor_id')->unsigned()->nullable()->default(null);
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
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->dropForeign('visitantes_presenciales_instructor_id_foreign');
            $table->dropColumn('instructor_id');
        });
    }
}
