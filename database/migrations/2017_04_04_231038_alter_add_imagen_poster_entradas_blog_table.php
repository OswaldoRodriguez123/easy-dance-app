<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddImagenPosterEntradasBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entradas_blog', function (Blueprint $table) {
            
            $table->dropColumn('imagen_footer');
            $table->string('imagen_poster');

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
            
            $table->dropColumn('imagen_poster');
            $table->string('imagen_footer');
            
        });

    }
}