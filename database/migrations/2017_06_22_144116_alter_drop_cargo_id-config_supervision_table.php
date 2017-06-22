<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropCargoIdConfigSupervisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_supervision', function (Blueprint $table) {
            $table->dropForeign('config_supervision_cargo_id_foreign');
            $table->dropColumn('cargo_id');

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
            $table->integer('cargo_id')->default(1);
        });
    }
}