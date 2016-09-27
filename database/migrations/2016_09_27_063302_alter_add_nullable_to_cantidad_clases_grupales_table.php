<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddNullableToCantidadClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            
            $table->integer('cantidad_hombres')->nullable()->change();
            $table->integer('cantidad_mujeres')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('clases_grupales', function (Blueprint $table) {
            
            $table->integer('cantidad_hombres')->nullable(false)->change();
            $table->integer('cantidad_mujeres')->nullable(false)->change();
            
        });

    }
}
