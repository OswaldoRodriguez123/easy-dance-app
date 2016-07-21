<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('familia_id')->after('academia_id')->unsigned()->nullable()->default(null);
            $table->foreign('familia_id')->references('id')->on('familias');
            $table->integer('usuario_id')->after('familia_id')->unsigned()->nullable()->default(null);
            $table->integer('usuario_tipo')->after('usuario_id')->unsigned()->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_familia_id_foreign');
            $table->dropColumn('familia_id');
            $table->dropColumn('usuario_id');
            $table->dropColumn('usuario_tipo');
        });
    }
}
