<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewIncidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('incidencias');

        Schema::create('incidencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('usuario_id')->unsigned();
            $table->integer('usuario_tipo')->default(1);
            $table->integer('gravedad_id')->unsigned();
            $table->foreign('gravedad_id')->references('id')->on('gravedades');
            $table->integer('administrador_id')->unsigned();
            $table->date('fecha');
            $table->text('mensaje');
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
        Schema::drop('incidencias');

        Schema::create('incidencias', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->date('fecha');
            $table->string('mensaje',10000);
            $table->timestamps();
        });
    }
}
