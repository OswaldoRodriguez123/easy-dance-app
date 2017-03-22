<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddInteresIdVisitantesPresencialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            
            $table->integer('interes_id')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('visitantes_presenciales', function (Blueprint $table) {
            
            $table->dropColumn('interes_id');
            
        });

    }
}

