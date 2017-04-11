<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddCantidadVisitasEntradasBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('entradas_blog', function (Blueprint $table) {
            
            $table->integer('cantidad_visitas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entradas_blog', function (Blueprint $table) {
            
            $table->dropColumn('cantidad_visitas');

        });
    }
}
