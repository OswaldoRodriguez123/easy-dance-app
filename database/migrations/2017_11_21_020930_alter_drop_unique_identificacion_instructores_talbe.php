<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropUniqueIdentificacionInstructoresTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instructores', function(Blueprint $table)
        {
            $table->dropUnique('instructores_identificacion_unique');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instructores', function(Blueprint $table)
        {
            //Put the index back when the migration is rolled back
            $table->unique('identificacion');

        });
    }
}
