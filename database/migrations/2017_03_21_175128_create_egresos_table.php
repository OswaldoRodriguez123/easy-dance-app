<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('egresos', function(Blueprint $table)
        {
            $table->increments('id');  

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');        

            $table->integer('tipo');
            $table->integer('tipo_id');
            $table->string('factura');
            $table->integer('config_tipo');
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
        Schema::drop('egresos');
    }
}
