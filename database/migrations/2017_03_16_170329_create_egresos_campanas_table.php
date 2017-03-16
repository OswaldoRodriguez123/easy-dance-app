<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresosCampanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresos_campanas', function(Blueprint $table)
        {
            $table->increments('id');  

            $table->integer('campana_id')->unsigned();
            $table->foreign('campana_id')->references('id')->on('campanas');        

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
        Schema::drop('egresos_campanas');
    }
}