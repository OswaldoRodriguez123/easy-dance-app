<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddPasswordSupervisionAcademiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('academias', function (Blueprint $table) {
            $table->string('password_supervision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academias', function (Blueprint $table) {
            $table->dropColumn('password_supervision');
        });
    }
}