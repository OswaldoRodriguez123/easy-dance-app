<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropForeignAddBloggersToEntradasBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entradas_blog', function (Blueprint $table) {
            $table->dropForeign('entradas_blog_usuario_id_foreign');
            $table->foreign('usuario_id')->references('id')->on('bloggers');

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
            $table->dropForeign('entradas_blog_usuario_id_foreign');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }
}
