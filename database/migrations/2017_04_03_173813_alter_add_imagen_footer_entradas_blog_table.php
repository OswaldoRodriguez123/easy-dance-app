<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddImagenFooterEntradasBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entradas_blog', function (Blueprint $table) {
            
            $table->string('imagen_footer');

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
            
            $table->dropColumn('imagen_footer');
            
        });

    }
}
