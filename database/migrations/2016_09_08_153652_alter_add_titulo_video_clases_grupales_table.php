<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTituloVideoClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_grupales', function (Blueprint $table) {
            
            $table->string('titulo_video');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('clases_grupales', function (Blueprint $table) {
            
            $table->dropColumn('titulo_video');
            
        });

    }
}
