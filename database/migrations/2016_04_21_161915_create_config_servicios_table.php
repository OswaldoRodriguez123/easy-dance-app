<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_servicios', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',15);
            $table->integer('costo');
            $table->string('impuesto',20);
            $table->string('imagen')->nullable();
            $table->string('descripcion',300);
            $table->integer('cantidad_sesiones')->nullable();
            $table->integer('meses_expiracion')->nullable();
            $table->tinyinteger('meses_despues')->nullable();
            $table->tinyinteger('incluye_iva');

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
        Schema::drop('config_servicios');
    }

}
