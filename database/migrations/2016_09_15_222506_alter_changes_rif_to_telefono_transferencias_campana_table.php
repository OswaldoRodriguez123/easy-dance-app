<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangesRifToTelefonoTransferenciasCampanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferencias_campana', function (Blueprint $table) {
            
            $table->renameColumn('rif', 'telefono');

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
            
            $table->renameColumn('telefono', 'rif');
            
        });

    }
}
