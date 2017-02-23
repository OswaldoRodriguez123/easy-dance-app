<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostoClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('costo_clases_personalizadas', function(Blueprint $table)
        {
            $table->increments('id'); 

            $table->integer('clase_personalizada_id')->unsigned();
            $table->integer('participantes');
            $table->float('precio');

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
        Schema::drop('costo_clases_personalizadas');
    }
}
