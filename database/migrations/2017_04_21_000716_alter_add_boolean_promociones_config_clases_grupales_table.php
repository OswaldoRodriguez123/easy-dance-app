<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanPromocionesConfigClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_clases_grupales', function (Blueprint $table) {
            
            $table->integer('boolean_promociones')->default(1);

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::table('config_clases_grupales', function (Blueprint $table) {
            
            $table->dropColumn('boolean_promociones');
            
        });

    }
}
