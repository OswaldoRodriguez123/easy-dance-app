<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_personalizadas', function (Blueprint $table) {
            
            $table->string('nombre');
            $table->float('costo');
   

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
            
            $table->dropColumn('nombre');
            $table->dropColumn('costo');
            
        });

    }
}
