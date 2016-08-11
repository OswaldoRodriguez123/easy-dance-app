<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddImagenClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_personalizadas', function (Blueprint $table) {
            
            $table->string('imagen');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('clases_personalizadas', function (Blueprint $table) {
            
            $table->dropColumn('imagen');
            
        });

    }
}
