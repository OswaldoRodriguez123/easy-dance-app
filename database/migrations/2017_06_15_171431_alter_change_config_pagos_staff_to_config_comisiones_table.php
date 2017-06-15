<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeConfigPagosStaffToConfigComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('config_pagos_staff', function (Blueprint $table) {
            $table->dropForeign('config_pagos_staff_staff_id_foreign');
            $table->renameColumn('staff_id', 'usuario_id');
        });

        Schema::rename('config_pagos_staff', 'config_comisiones');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('config_comisiones', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'staff_id');
        });

        Schema::rename('config_comisiones', 'config_pagos_staff');

    }
}
