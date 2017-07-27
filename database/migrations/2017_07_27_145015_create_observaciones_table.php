<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('observaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_evento');
            $table->integer('tipo_evento_id');
            $table->integer('tipo_usuario');
            $table->integer('tipo_usuario_id');
            $table->string('observacion');
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
        Schema::drop('observaciones');
    }
}
