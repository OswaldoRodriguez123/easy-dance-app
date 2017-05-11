<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddNuevosCamposPaquetesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            $table->string('imagen');
            $table->dropColumn('etiqueta');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            $table->dropColumn('imagen');
            $table->string('etiqueta');
            $table->dropColumn('deleted_at');
        });
    }
}
