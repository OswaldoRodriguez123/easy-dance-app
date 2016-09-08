<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddImagenConfigClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_clases_grupales', function (Blueprint $table) {
            
            $table->string('imagen');

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
            
            $table->dropColumn('imagen');
            
        });

    }
}
