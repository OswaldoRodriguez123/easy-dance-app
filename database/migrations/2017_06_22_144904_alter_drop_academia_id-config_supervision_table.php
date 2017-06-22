<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropAcademiaIdConfigSupervisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_supervision', function (Blueprint $table) {
            $table->dropForeign('config_supervision_academia_id_foreign');
            $table->dropColumn('academia_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_supervision', function (Blueprint $table) {
            $table->integer('academia_id')->default(1);
        });
    }
}
