<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',50);
            $table->string('descripcion',500);
            $table->date('fecha');
            $table->string('hora_inicio');
            $table->string('hora_final');
            $table->string('lugar',30);
            $table->string('etiqueta',30);

            $table->string('nombre_representante',50);
            $table->string('telefono_representante',11);
            $table->string('celular_representante',11);
            $table->string('correo_representante',30);
            
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
        Schema::drop('shows');
    }

}