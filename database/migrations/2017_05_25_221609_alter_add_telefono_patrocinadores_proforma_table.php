<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTelefonoPatrocinadoresProformaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patrocinadores_proforma', function (Blueprint $table) {
            $table->string('telefono');
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
            $table->dropColumn('telefono');
        });
    }
}
