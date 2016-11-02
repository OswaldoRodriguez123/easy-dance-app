<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPerfilEvaluativoDropForeighUsuarioIdTable extends Migration
{
    public function up()
    {
        Schema::table('perfil_evaluativo', function (Blueprint $table) {
            $table->dropForeign('perfil_evaluativo_usuario_id_foreign');
        });
    }

    public function down()
    {
        Schema::table('perfil_evaluativo', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }
}
