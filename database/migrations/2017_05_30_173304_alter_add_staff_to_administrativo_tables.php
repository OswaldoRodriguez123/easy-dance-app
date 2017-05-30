<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddStaffToAdministrativoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->dropForeign('items_factura_proforma_alumno_id_foreign');
            $table->renameColumn('alumno_id', 'usuario_id');
            $table->integer('usuario_tipo')->default(1);
        });

        Schema::table('facturas', function (Blueprint $table) {
            $table->dropForeign('facturas_alumno_id_foreign');
            $table->renameColumn('alumno_id', 'usuario_id');
            $table->integer('usuario_tipo')->default(1);
        });

        Schema::table('acuerdos', function (Blueprint $table) {
            $table->dropForeign('acuerdos_alumno_id_foreign');
            $table->renameColumn('alumno_id', 'usuario_id');
            $table->integer('usuario_tipo')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items_factura_proforma', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'alumno_id');
            $table->dropColumn('usuario_tipo');
        });

        Schema::table('facturas', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'alumno_id');
            $table->dropColumn('usuario_tipo');
        });

        Schema::table('acuerdos', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'alumno_id');
            $table->dropColumn('usuario_tipo');
        });
    }
}
