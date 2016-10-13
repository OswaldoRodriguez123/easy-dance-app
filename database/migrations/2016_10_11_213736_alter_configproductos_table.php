<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigproductosTable extends Migration
{
    public function up()
    {
        Schema::table('config_productos', function (Blueprint $table) {
            $table->integer('cantidad');
        });
    }

    public function down()
    {
        Schema::table('config_productos', function (Blueprint $table) {
            $table->dropColumn('cantidad');
        });
    }
}
