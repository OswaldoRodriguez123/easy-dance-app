<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('reservaciones', function (Blueprint $table) {
            
            $table->string('celular')->after('telefono');
            $table->string('codigo_reservacion')->after('tipo_id');
            $table->boolean('estatus')->after('codigo_reservacion')->default(0);
            
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
            
            $table->dropColumn('celular');
            $table->dropColumn('codigo_reservacion');
            $table->dropColumn('estatus');
            
        });

    }
}
