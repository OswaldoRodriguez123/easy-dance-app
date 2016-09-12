<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeHistoriaPresentacionCampanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campanas', function (Blueprint $table) {
            
            $table->text('historia', 10000)->change();
            $table->text('presentacion', 10000)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('campanas', function (Blueprint $table) {
            
            $table->string('historia', 1000)->change();
            $table->string('presentacion', 1000)->change();
            
        });

    }
}

