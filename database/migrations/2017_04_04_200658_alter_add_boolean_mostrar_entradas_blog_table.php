<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanMostrarEntradasBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('entradas_blog', function (Blueprint $table) {
            $table->boolean('boolean_mostrar')->default(0);
            
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
            $table->dropColumn('boolean_mostrar');
        });
    }
}
