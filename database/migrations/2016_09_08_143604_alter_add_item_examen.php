<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddItemExamen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examenes', function (Blueprint $table) {
            
            $table->boolean('tiempos_musicales')->default(0);
            $table->boolean('compromiso')->default(0);
            $table->boolean('condicion')->default(0);
            $table->boolean('habilidades')->default(0);
            $table->boolean('disciplina')->default(0);
            $table->boolean('expresion_corporal')->default(0);
            $table->boolean('expresion_facial')->default(0);
            $table->boolean('destreza')->default(0);
            $table->boolean('dedicacion')->default(0);
            $table->boolean('oido_musical')->default(0);
            $table->boolean('postura')->default(0);
            $table->boolean('respeto')->default(0);
            $table->boolean('elasticidad')->default(0);
            $table->boolean('complejidad_de_movimientos')->default(0);
            $table->boolean('asistencia')->default(0);
            $table->boolean('estilo')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examenes', function (Blueprint $table) {
            
            $table->dropColumn('tiempos_musicales');
            $table->dropColumn('compromiso');
            $table->dropColumn('condicion');
            $table->dropColumn('habilidades');
            $table->dropColumn('disciplina');
            $table->dropColumn('expresion_corporal');
            $table->dropColumn('expresion_facial');
            $table->dropColumn('destreza');
            $table->dropColumn('dedicacion');
            $table->dropColumn('oido_musical');
            $table->dropColumn('postura');
            $table->dropColumn('respeto');
            $table->dropColumn('elasticidad');
            $table->dropColumn('complejidad_de_movimientos');
            $table->dropColumn('asistencia');
            $table->dropColumn('estilo');
        });
    }
}
