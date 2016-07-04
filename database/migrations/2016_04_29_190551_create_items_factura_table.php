<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_factura', function(Blueprint $table)
        {
            $table->increments('id'); 

            $table->integer('factura_id')->unsigned();
            $table->foreign('factura_id')->references('id')->on('facturas');         
            $table->integer('item_id');
            $table->string('nombre');
            $table->string('tipo');
            $table->integer('cantidad');
            $table->float('precio_neto');
            $table->float('impuesto');
            $table->float('importe_neto');
            
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
        Schema::drop('items_factura');
    }

}
