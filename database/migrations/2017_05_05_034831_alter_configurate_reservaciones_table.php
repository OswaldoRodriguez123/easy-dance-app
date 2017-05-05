<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigurateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservaciones', function (Blueprint $table) {
            $table->renameColumn('tipo_id', 'tipo_reservacion_id');
            $table->integer('tipo_usuario');
            $table->integer('tipo_usuario_id');
            $table->date('fecha_vencimiento');
            $table->dropColumn('nombre');
            $table->dropColumn('telefono');
            $table->dropColumn('celular');
            $table->dropColumn('sexo');
            $table->dropColumn('correo');
            $table->dropColumn('codigo_reservacion');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservaciones', function (Blueprint $table) {
            $table->renameColumn('tipo_reservacion_id', 'tipo_id');
            $table->dropColumn('tipo_usuario');
            $table->dropColumn('tipo_usuario_id');
            $table->dropColumn('fecha_vencimiento');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('celular');
            $table->string('sexo');
            $table->string('correo');
            $table->string('codigo_reservacion');

        });
    }
}
