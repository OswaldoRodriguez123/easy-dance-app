<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsAcuerdoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_acuerdo', function(Blueprint $table)
        {
            $table->increments('id'); 

            $table->integer('acuerdo_id')->unsigned();
            $table->foreign('acuerdo_id')->references('id')->on('acuerdos');
            $table->date('fecha');

            $table->integer('item_id');
            $table->string('nombre');
            $table->string('tipo');
            $table->integer('cantidad');
            $table->float('precio_neto');
            $table->float('impuesto');
            $table->float('importe_neto');
            $table->date('fecha_vencimiento');
            
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
        Schema::drop('items_acuerdo');
    }

}
