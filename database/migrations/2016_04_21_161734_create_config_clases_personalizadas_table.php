<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigClasesPersonalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_clases_personalizadas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',15);
            $table->integer('costo');
            $table->tinyinteger('impuesto');
            $table->string('descripcion',300);

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
        Schema::drop('config_clases_personalizadas');
    }

}
