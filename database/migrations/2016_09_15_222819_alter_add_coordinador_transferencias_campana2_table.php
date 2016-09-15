<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddCoordinadorTransferenciasCampana2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferencias_campana', function (Blueprint $table) {
            
            $table->string('coordinador');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('transferencias_campana', function (Blueprint $table) {
            
            $table->dropColumn('coordinador');
            
        });

    }
}
