<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddAcademiaIdComisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comisiones', function (Blueprint $table) {
            $table->integer('academia_id')->unsigned()->nullable()->default(null);
            $table->foreign('academia_id')->references('id')->on('academias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comisiones', function (Blueprint $table) {
            $table->dropForeign('comisiones_academia_id_foreign');
            $table->dropColumn('academia_id');
        });
    }
}
