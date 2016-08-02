<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRegalosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regalos', function (Blueprint $table) {
            
            $table->string('imagen')->after('descripcion');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('regalos', function (Blueprint $table) {
            
            $table->dropColumn('imagen');
            
        });

    }
}
