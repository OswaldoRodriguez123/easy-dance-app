<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresosTalleresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresos_talleres', function(Blueprint $table)
        {
            $table->increments('id');  

            $table->integer('taller_id')->unsigned();
            $table->foreign('taller_id')->references('id')->on('talleres');        

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
        Schema::drop('egresos_talleres');
    }
}
