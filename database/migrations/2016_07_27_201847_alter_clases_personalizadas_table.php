<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clases_personalizadas', function (Blueprint $table) {
            
            $table->dropColumn('condiciones');
            
        });

        Schema::table('config_clases_personalizadas', function (Blueprint $table) {
            
            $table->string('condiciones', 15000)->after('ventajas');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('config_clases_personalizadas', function (Blueprint $table) {
            
            $table->dropColumn('condiciones');
            
        });

        Schema::table('clases_personalizadas', function (Blueprint $table) {
            
            $table->string('condiciones')->after('descripcion');
            
        });
    }
}
