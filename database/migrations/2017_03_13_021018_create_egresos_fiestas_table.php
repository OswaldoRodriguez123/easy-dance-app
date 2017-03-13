<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresosFiestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresos_fiestas', function(Blueprint $table)
        {
            $table->increments('id');  

            $table->integer('fiesta_id')->unsigned();
            $table->foreign('fiesta_id')->references('id')->on('fiestas');        

            $table->string('factura');
            $table->string('concepto');
            $table->float('cantidad');
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
        Schema::drop('egresos_fiestas');
    }
}
