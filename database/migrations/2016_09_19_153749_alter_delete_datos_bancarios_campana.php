<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDeleteDatosBancariosCampana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('campanas', function (Blueprint $table) {
            
            $table->dropColumn('correo');
            $table->dropColumn('tipo_cuenta');
            $table->dropColumn('numero_cuenta');
            $table->dropColumn('rif');
            $table->dropColumn('nombre_banco');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('campanas', function (Blueprint $table) {
            
            $table->string('correo');
            $table->string('tipo_cuenta');
            $table->string('numero_cuenta');
            $table->string('rif');
            $table->string('nombre_banco');
            
        });
    }
}
