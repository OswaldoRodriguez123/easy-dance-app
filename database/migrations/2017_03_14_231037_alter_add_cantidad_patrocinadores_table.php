<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddCantidadPatrocinadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patrocinadores', function (Blueprint $table) {
            
            $table->integer('cantidad')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('patrocinadores', function (Blueprint $table) {
            
            $table->dropColumn('cantidad');
            
        });

    }
}
