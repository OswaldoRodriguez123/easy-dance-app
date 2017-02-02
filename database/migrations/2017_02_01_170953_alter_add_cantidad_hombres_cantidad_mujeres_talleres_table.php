<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddCantidadHombresCantidadMujeresTalleresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talleres', function (Blueprint $table) {
            $table->integer('cantidad_hombres')->nullable()->default(null);
            $table->integer('cantidad_mujeres')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talleres', function (Blueprint $table) {
            $table->dropColumn('cantidad_hombres');
            $table->dropColumn('cantidad_mujeres');
        });
    }
}

