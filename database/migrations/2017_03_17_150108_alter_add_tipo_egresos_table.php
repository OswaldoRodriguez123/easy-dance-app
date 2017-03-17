<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddTipoEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egresos_generales', function (Blueprint $table) {
            
            $table->tinyinteger('tipo')->default(1);

        });


        Schema::table('egresos_talleres', function (Blueprint $table) {
            
            $table->tinyinteger('tipo')->default(1);

        });

        Schema::table('egresos_fiestas', function (Blueprint $table) {
            
            $table->tinyinteger('tipo')->default(1);

        });

        Schema::table('egresos_campanas', function (Blueprint $table) {
            
            $table->tinyinteger('tipo')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egresos_generales', function (Blueprint $table) {
            
            $table->dropColumn('tipo');
            
        });

        Schema::table('egresos_talleres', function (Blueprint $table) {
            
            $table->dropColumn('tipo');
            
        });
        
        Schema::table('egresos_fiestas', function (Blueprint $table) {
            
            $table->dropColumn('tipo');
            
        });

        Schema::table('egresos_campanas', function (Blueprint $table) {
            
            $table->dropColumn('tipo');
            
        });

    }
}
