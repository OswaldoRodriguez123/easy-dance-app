<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterItemsExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items_examenes', function (Blueprint $table) {
            $table->integer('examen_id')->after('academia_id')->unsigned();
            $table->foreign('examen_id')->references('id')->on('examenes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items_examenes', function (Blueprint $table) {
            $table->dropForeign('items_examenes_examen_id_foreign');
            //$table->dropColumn('examen_id');
        });
    }
}
