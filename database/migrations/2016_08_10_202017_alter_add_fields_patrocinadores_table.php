<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddFieldsPatrocinadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patrocinadores', function (Blueprint $table) {
            $table->integer('user_id')->after('monto')->nullable();
            $table->integer('externo_id')->after('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patrocinadores', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('externo_id');
        });
    }
}
