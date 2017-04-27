<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupervisionEvaluacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervision_evaluacion', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('supervisor_id')->unsigned();
            $table->foreign('supervisor_id')->references('id')->on('staff');
            $table->integer('supervision_id')->unsigned();
            $table->foreign('supervision_id')->references('id')->on('supervisiones');
            $table->string('total');
            $table->string('observacion');
            $table->string('porcentaje');

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
        Schema::drop('supervision_evaluacion');
    }

}    
