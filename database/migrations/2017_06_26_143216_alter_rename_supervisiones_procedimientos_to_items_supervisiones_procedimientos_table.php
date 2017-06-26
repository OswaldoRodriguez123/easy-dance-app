<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRenameSupervisionesProcedimientosToItemsSupervisionesProcedimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('supervisiones_procedimientos', 'items_procedimientos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('items_procedimientos', 'supervisiones_procedimientos');
    }
}
