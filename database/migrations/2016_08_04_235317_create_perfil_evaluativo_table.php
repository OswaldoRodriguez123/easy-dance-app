<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilEvaluativoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_evaluativo', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->tinyinteger('aprendizaje');
            $table->tinyinteger('actividad');
            $table->tinyinteger('beneficio');
            $table->tinyinteger('motivado');
            $table->tinyinteger('dedicacion');
            $table->tinyinteger('velocidad');
            $table->tinyinteger('seguridad');
            $table->tinyinteger('participacion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('perfil_evaluativo');
    }

}
