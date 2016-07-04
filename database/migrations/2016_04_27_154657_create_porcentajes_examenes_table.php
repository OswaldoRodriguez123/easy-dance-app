<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePorcentajesExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
    Schema::create('porcentajes_examenes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('porcentaje');
            
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items_examenes');

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
        Schema::drop('porcentajes_examenes');
    }

}
