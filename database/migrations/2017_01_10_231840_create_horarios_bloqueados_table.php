<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosBloqueadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_bloqueados', function(Blueprint $table)
        {
            $table->increments('id');

            $table->tinyinteger('tipo');
            $table->integer('tipo_id')->unsigned();

            $table->date('fecha_inicio');
            $table->date('fecha_final');

            $table->string('razon_cancelacion');

            $table->boolean('boolean_mostrar')->default(1);


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
        Schema::drop('horarios_bloqueados');
    }

}
