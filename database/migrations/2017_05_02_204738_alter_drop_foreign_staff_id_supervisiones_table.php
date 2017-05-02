<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDropForeignStaffIdSupervisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supervisiones', function (Blueprint $table) {
            $table->dropForeign('supervisiones_staff_id_foreign');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supervisiones', function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on('staff');
        });
    }
}
