<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCambiosRegalosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('regalos', function (Blueprint $table) {
            $table->dropColumn('dirigido_a');
            $table->dropColumn('de_parte_de');
            $table->dropColumn('correo');

        }); */   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('regalos', function (Blueprint $table) {
            $table->string('dirigido_a');
            $table->string('de_parte_de');
            $table->string('correo');
        });*/        //
    }
}
