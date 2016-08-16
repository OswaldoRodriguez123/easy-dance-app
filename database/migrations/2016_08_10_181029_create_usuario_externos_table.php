<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioExternosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_externos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nombre',50);
            $table->string('apellido', 50);
            $table->string('correo');
            $table->integer('campana_id');
            $table->decimal('monto', 8, 2);
            
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
        Schema::drop('usuario_externos');
    }
}
