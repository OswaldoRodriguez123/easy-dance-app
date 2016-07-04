<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('impuesto', function(Blueprint $table)
        {
            $table->increments('id');           

            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('paises');
            $table->integer('impuesto');
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
        Schema::drop('impuesto');
    }

}
