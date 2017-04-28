<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddSupervisorIdHorariosSupervisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horarios_supervision', function (Blueprint $table) {
            $table->integer('supervisor_id')->unsigned()->nullable()->default(null);
            $table->foreign('supervisor_id')->references('id')->on('staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horarios_supervision', function (Blueprint $table) {
            $table->dropForeign('horarios_supervision_supervisor_id_foreign');
            $table->dropColumn('supervisor_id');
        });
    }
}
