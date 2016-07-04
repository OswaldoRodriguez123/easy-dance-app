<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigClasesGrupalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_clases_grupales', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',50);
            $table->integer('costo_inscripcion');
            $table->integer('costo_mensualidad');
            $table->boolean('incluye_iva');
            $table->string('descripcion',300);
            $table->string('condiciones');
            $table->integer('porcentaje_retraso');
            $table->integer('tiempo_tolerancia');

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
        Schema::drop('config_clases_grupales');
    }

}
