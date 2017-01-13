<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NivelacionesTuclasedebaile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nivelaciones_tuclasedebaile', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('clase_grupal_id')->unsigned();
            $table->foreign('clase_grupal_id')->references('id')->on('clases_grupales');

            $table->tinyinteger('tipo');

            $table->boolean('clase_1')->default(0);
            $table->boolean('clase_2')->default(0);
            $table->boolean('clase_3')->default(0);
            $table->boolean('clase_4')->default(0);


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
        Schema::drop('nivelaciones_tuclasedebaile');
    }

}
