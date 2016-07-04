<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examenes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->integer('instructor_id')->unsigned();
            $table->foreign('instructor_id')->references('id')->on('instructores');
            $table->string('nombre',50);
            $table->date('fecha');
            $table->string('descripcion');
            $table->string('condiciones');
            $table->string('color_etiqueta',30);

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
        Schema::drop('examenes');
    }

}
