<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupervisionesProcedimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisiones_procedimientos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('config_supervision_id')->unsigned();
            $table->foreign('config_supervision_id')->references('id')->on('config_supervision');
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
        Schema::drop('supervisiones_procedimientos');
    }

}
