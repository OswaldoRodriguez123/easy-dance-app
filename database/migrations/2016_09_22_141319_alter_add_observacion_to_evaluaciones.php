<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddObservacionToEvaluaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->string('observacion', 1000);
            $table->double('porcentaje');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluaciones', function (Blueprint $table) {
            $table->dropColumn('observacion');
            $table->dropColumn('procentaje');
        });
    }
}
