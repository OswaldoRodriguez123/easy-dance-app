<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPromocionTable extends Migration
{
    
    public function up()
    {
        Schema::table('promociones', function (Blueprint $table) {
            
            $table->integer('condiciones');

        });
    }

    public function down()
    {
        Schema::table('promociones', function (Blueprint $table) {
            
            $table->dropColumn('condiciones');
            
        });
    }
}
