<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCodigos extends Migration
{
    public function up()
    {
        Schema::table('codigos', function (Blueprint $table) {
            
            $table->integer('numero_canjeos');

        });
    }

    public function down()
    {

        Schema::table('codigos', function (Blueprint $table) {
            
            $table->dropColumn('numero_canjeos');
            
        });

    }
}
