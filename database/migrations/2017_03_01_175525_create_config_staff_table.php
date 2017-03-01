<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_staff', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('academia_id')->unsigned()->nullable();
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->string('nombre');

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
        Schema::drop('config_staff');
    }

}
