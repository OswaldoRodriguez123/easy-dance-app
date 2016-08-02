<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCondicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_clases_grupales', function (Blueprint $table) {

            $table->string('condiciones', 10000)->change();
            
        });

        Schema::table('talleres', function (Blueprint $table) {

            $table->string('condiciones', 10000)->change();
            
        });

        Schema::table('fiestas', function (Blueprint $table) {

            $table->string('condiciones', 10000)->change();
            
        });

        Schema::table('campanas', function (Blueprint $table) {

            $table->string('condiciones', 10000)->change();
            
        });

        Schema::table('academias', function (Blueprint $table) {

            $table->string('normativa', 5000)->change();
            $table->string('manual', 5000)->change();
            
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_clases_grupales', function (Blueprint $table) {

            $table->string('condiciones')->change();
            
        });

        Schema::table('talleres', function (Blueprint $table) {

            $table->string('condiciones')->change();
            
        });

        Schema::table('fiestas', function (Blueprint $table) {

            $table->string('condiciones')->change();
            
        });

        Schema::table('campanas', function (Blueprint $table) {

            $table->string('condiciones')->change();
            
        });

        Schema::table('academias', function (Blueprint $table) {

            $table->string('normativa')->change();
            $table->string('manual')->change();
            
        });
    }
}
