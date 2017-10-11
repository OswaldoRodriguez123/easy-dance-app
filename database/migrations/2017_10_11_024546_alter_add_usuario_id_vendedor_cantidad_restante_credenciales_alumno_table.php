<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddUsuarioIdVendedorCantidadRestanteCredencialesAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('credenciales_alumno', function (Blueprint $table) {
            $table->integer('cantidad_restante');
            $table->integer('usuario_id_vendedor');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credenciales_alumno', function (Blueprint $table) {
            $table->dropColumn('cantidad_restante');
            $table->dropColumn('usuario_id_vendedor');
        });
    }
}
