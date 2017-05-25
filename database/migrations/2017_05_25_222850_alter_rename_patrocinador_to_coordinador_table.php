<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRenamePatrocinadorToCoordinadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patrocinadores_proforma', function (Blueprint $table) {
            $table->renameColumn('patrocinador', 'coordinador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patrocinadores_proforma', function (Blueprint $table) {
            $table->renameColumn('coordinador', 'patrocinador');
        });
    }
}
