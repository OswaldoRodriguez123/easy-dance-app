<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTransferenciaIdPatrocinadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patrocinadores', function (Blueprint $table) {
            
            $table->integer('transferencia_id');

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
            
            $table->dropColumn('transferencia_id');
            
        });

    }
}
