<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function(Blueprint $table)
        {
            $table->increments('id'); 
            $table->integer('numero_factura');   
            $table->string('concepto');        

            $table->integer('alumno_id')->unsigned();
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->date('fecha');
            $table->time('hora');

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
        Schema::drop('facturas');
    }

}
