<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaNotificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacion', function(Blueprint $table)
        {
            $table->increments('id');  
            $table->string('mensaje');
            $table->integer('tipo_evento');
            $table->integer('evento_id');
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('notificacion', function(Blueprint $table)
        {
            $table->drop('notificacion');
        });
    }
}
