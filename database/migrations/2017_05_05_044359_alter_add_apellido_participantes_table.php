<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddApellidoParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->string('apellido');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->dropColumn('apellido');
        });
    }
}

