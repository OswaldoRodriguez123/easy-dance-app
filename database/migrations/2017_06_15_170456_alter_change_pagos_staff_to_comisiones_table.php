<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangePagosStaffToComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('pagos_staff', function (Blueprint $table) {
            $table->dropForeign('pagos_staff_staff_id_foreign');
            $table->renameColumn('staff_id', 'usuario_id');
        });

        Schema::rename('pagos_staff', 'comisiones');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('comisiones', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'staff_id');
        });

        Schema::rename('comisiones', 'pagos_staff');

    }
}
