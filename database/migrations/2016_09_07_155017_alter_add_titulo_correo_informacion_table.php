<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTituloCorreoInformacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
       Schema::table('correo_informacion', function (Blueprint $table) {
            $table->string('titulo');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('correo_informacion', function (Blueprint $table) {
            $table->dropColumn('titulo');
        });
    }
}
