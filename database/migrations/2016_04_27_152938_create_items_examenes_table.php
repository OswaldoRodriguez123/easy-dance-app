<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_examenes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',50);
            
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
        Schema::drop('items_examenes');
    }

}
