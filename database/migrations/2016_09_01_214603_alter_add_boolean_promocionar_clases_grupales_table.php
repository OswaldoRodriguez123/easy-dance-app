<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanPromocionarClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('clases_grupales', function (Blueprint $table) {
            $table->boolean('boolean_promocionar')->default(1);
            
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
            $table->dropColumn('boolean_promocionar');
        });
    }
}
