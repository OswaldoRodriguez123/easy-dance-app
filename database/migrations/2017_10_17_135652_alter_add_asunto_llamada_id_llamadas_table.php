<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddAsuntoLlamadaIdLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('llamadas', function (Blueprint $table) {
            $table->integer('asunto_llamada_id');
            $table->dropColumn('fecha_siguiente');
            $table->dropColumn('hora_siguiente');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('llamadas', function (Blueprint $table) {
            $table->dropColumn('asunto_llamada_id');
            $table->date('fecha_siguiente');
            $table->time('hora_siguiente');
        });
    }
}

