<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosSupervisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_supervision', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('supervision_id')->unsigned();
            $table->foreign('supervision_id')->references('id')->on('supervisiones');
            $table->date('fecha');
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
        Schema::drop('horarios_supervision');
    }

}
