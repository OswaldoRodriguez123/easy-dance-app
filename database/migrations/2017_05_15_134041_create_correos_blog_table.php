<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorreosBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correos_blog', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('url');
            $table->integer('usuario_tipo');
            $table->integer('usuario_id');
            $table->integer('entrada_id');
            $table->boolean('boolean_visto')->default(0);

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
        Schema::drop('correos_blog');
    }
}
