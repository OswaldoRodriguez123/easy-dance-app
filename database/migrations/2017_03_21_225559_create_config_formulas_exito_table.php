<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigFormulasExitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_formulas_exito', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');   

            $table->string('nombre');

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
        Schema::drop('config_formulas_exito');
    }
}
