<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoletosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boletos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('tipo_evento')->default(1);
            $table->integer('tipo_evento_id');
            $table->integer('config_boleto_id')->unsigned();
            $table->foreign('config_boleto_id')->references('id')->on('config_boletos');
            $table->float('costo');
            $table->integer('cantidad')->default(1);
            
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
        Schema::drop('boletos');
    }
}
