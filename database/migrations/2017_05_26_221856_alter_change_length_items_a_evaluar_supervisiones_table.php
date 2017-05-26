<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeLengthItemsAEvaluarSupervisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supervisiones', function (Blueprint $table) {
            $table->text('items_a_evaluar')->change();
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
            $table->string('items_a_evaluar')->change();
        });
    }
}
