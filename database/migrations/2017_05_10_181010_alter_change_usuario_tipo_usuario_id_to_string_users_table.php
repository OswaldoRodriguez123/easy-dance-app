<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChangeUsuarioTipoUsuarioIdToStringUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('usuario_id')->change();
            $table->string('usuario_tipo')->change();
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
            $table->integer('usuario_id')>unsigned()->nullable()->default(null)->change();
            $table->integer('usuario_tipo')->unsigned()->nullable()->default(1)->change();
        });
    }
}
