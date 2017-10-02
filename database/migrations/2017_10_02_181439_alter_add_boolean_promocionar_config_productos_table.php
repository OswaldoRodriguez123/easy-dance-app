<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanPromocionarConfigProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('config_productos', function (Blueprint $table) {
            $table->boolean('boolean_promocionar')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_productos', function (Blueprint $table) {
            $table->dropColumn('boolean_promocionar');
        });
    }
}
