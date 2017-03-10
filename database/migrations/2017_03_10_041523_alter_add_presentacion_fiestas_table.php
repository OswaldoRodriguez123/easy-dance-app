<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddPresentacionFiestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiestas', function (Blueprint $table) {
            $table->string('presentacion')->after('imagen');
            $table->string('imagen_presentacion')->after('imagen');
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
            $table->dropColumn('presentacion');
            $table->dropColumn('imagen_presentacion');
        });
    }
}
