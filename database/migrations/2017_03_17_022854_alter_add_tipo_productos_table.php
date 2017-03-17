<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_productos', function (Blueprint $table) {
            
            $table->tinyinteger('tipo')->default(2);

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
            
            $table->dropColumn('tipo');
            
        });

    }
}
