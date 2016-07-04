<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigNivelesBaileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_niveles_baile', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->nullable()->unsigned();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre',30);

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
        Schema::drop('config_niveles_baile');
    }

}