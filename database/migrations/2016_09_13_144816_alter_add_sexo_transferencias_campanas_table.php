<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddSexoTransferenciasCampanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferencias_campana', function (Blueprint $table) {
            
            $table->string('sexo', 15);

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
            
            $table->dropColumn('sexo');
            
        });

    }
}
