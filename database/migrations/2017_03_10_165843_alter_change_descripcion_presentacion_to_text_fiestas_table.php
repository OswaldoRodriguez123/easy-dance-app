<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeDescripcionPresentacionToTextFiestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiestas', function (Blueprint $table) {
            
            $table->text('descripcion', 10000)->change();
            $table->text('presentacion', 10000)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('fiestas', function (Blueprint $table) {
            
            $table->string('descripcion', 1000)->change();
            $table->string('presentacion', 1000)->change();
            
        });

    }
}
