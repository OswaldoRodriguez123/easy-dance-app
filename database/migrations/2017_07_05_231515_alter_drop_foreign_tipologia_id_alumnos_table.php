<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropForeignTipologiaIdAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropForeign('alumnos_tipologia_id_foreign');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('alumnos', function (Blueprint $table) {
            $table->foreign('tipologia_id')->references('id')->on('tipologias');
        });
    }
}
