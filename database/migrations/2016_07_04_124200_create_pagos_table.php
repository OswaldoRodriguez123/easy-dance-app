<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pagos', function(Blueprint $table)
        {
            $table->increments('id'); 

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');     
            $table->date('fecha');
            $table->integer('factura_id')->unsigned();
            $table->foreign('factura_id')->references('id')->on('facturas');  
            $table->float('monto');
            $table->string('referencia');
            $table->string('forma_pago');
            $table->string('banco');
            
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
        Schema::drop('pagos');
    }
}
