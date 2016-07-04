<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComoNosConocisteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
    Schema::create('config_como_nos_conociste', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre');

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
        Schema::drop('config_como_nos_conociste');
    }

}
