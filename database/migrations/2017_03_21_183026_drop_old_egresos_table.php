<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOldEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::drop('egresos_generales');
        Schema::drop('egresos_campanas');
        Schema::drop('egresos_talleres');
        Schema::drop('egresos_fiestas');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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

        Schema::create('egresos_generales', function(Blueprint $table)
        {
            $table->increments('id');  

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');        

            $table->string('factura');
            $table->string('concepto');
            $table->float('cantidad');
            $table->timestamps();
        });

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
}
