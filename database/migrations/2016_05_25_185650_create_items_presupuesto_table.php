<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsPresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_presupuesto', function(Blueprint $table)
        {
            $table->increments('id'); 

            $table->integer('presupuesto_id')->unsigned();
            $table->foreign('presupuesto_id')->references('id')->on('presupuestos');         
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
        Schema::drop('items_presupuesto');
    }

}
