<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_staff', function(Blueprint $table)
        {
            $table->increments('id');         

            $table->integer('staff_id')->unsigned();
            $table->foreign('staff_id')->references('id')->on('staff');

            $table->integer('servicio_id')->unsigned();
            $table->foreign('servicio_id')->references('id')->on('config_servicios');

            $table->tinyinteger('tipo')->default(1);
            $table->double('monto');

            $table->boolean('boolean_pago')->default(0);


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
        Schema::drop('pagos_staff');
    }
}
