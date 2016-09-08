<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorreoInformacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correo_informacion', function(Blueprint $table)
        {
            $table->increments('id');  
            $table->integer('academia_id')->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');       
            $table->string('url');
            $table->string('imagen');
            $table->string('msj_html', 1000);

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
        Schema::drop('correo_informacion');
    }

}
