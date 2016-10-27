<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPaisesTable extends Migration
{
    public function up()
    {
        Schema::table('paises', function (Blueprint $table) {
            $table->integer('codigo');
            $table->string('abreviatura');
        });
    }

    public function down()
    {
        Schema::table('paises', function (Blueprint $table) {
            $table->dropColumn('codigo');
            $table->dropColumn('abreviatura');
        });
    }
}
