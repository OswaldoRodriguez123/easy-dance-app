<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigSupervisionesEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_supervisiones_evaluaciones', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('supervision_id')->unsigned();
            $table->foreign('supervision_id')->references('id')->on('supervisiones');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->integer('procedimiento_id')->unsigned();
            $table->foreign('procedimiento_id')->references('id')->on('config_supervision');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('config_supervisiones_evaluaciones');
    }

}
