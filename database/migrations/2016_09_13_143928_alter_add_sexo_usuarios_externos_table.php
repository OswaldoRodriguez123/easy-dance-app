<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddSexoUsuariosExternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('usuario_externos', function (Blueprint $table) {
            
            $table->string('sexo', 15);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('usuario_externos', function (Blueprint $table) {
            
            $table->dropColumn('sexo');
            
        });

    }
}
