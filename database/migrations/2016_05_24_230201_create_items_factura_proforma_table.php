<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsFacturaProformaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_factura_proforma', function(Blueprint $table)
        {
            $table->increments('id'); 

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');
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
        Schema::drop('items_factura_proforma');
    }

}
