<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDescripcionResumenArtisticoInstructoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instructores', function (Blueprint $table) {

            $table->string('descripcion', 2000)->change();
            $table->string('resumen_artistico', 2000)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instructores', function (Blueprint $table) {
            $table->string('descripcion', 1000)->change();
            $table->string('resumen_artistico', 1000)->change();
        });
    }
}
