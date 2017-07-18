<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddCamposEncuestasToVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            $table->tinyinteger('rapidez');
            $table->tinyinteger('calidad');
            $table->tinyinteger('satisfaccion');
            $table->tinyinteger('disponibilidad');
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
            $table->dropColumn('rapidez');
            $table->dropColumn('calidad');
            $table->dropColumn('satisfaccion');
            $table->dropColumn('disponibilidad');
        });
    }
}
