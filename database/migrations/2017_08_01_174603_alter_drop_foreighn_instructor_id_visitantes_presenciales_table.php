<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropForeighnInstructorIdVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->dropForeign('visitantes_presenciales_instructor_id_foreign');
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
            $table->foreign('instructor_id')->references('id')->on('staff');
        });
    }
}
