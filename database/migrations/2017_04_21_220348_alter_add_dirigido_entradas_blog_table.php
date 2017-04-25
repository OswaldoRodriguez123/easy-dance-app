<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddDirigidoEntradasBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entradas_blog', function (Blueprint $table) {
            $table->tinyinteger('dirigido')->default(1);
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
            $table->dropColumn('dirigido');
        });
    }
}
