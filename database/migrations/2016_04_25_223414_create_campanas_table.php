<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->integer('cantidad');
            $table->string('moneda',50);
            $table->string('nombre',50);
            $table->string('eslogan',50);
            $table->string('historia');
            $table->integer('plazo');
            $table->string('link_video');
            $table->string('correo');
            $table->string('numero_cuenta');
            $table->string('nombre_banco');
            $table->string('tipo_cuenta');
            $table->string('rif');
            $table->string('condiciones',1500);
            $table->string('imagen',50);
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
        Schema::drop('campanas');
    }

}