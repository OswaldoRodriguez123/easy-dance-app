<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeFloatToDecimalCostoClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('costo_clases_personalizadas', function (Blueprint $table) {
            
            $table->decimal('precio',19,4)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('costo_clases_personalizadas', function (Blueprint $table) {
            
            $table->float('precio')->change();
            
        });

    }
}
