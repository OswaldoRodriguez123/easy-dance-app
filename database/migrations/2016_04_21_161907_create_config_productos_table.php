<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_productos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',15);
            $table->integer('costo');
            $table->tinyinteger('sesiones');
            $table->tinyinteger('servicio_expira');
            $table->string('meses_despues');
            $table->string('imagen')->nullable();
            $table->string('descripcion');
            $table->boolean('incluye_iva');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('config_productos');
    }

}