<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanGrupalClaseGrupalIdExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('examenes', function (Blueprint $table) {
            $table->boolean('boolean_grupal')->default(0);
            $table->integer('clase_grupal_id')->nullable()->default(null);
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
            $table->dropColumn('boolean_grupal');
            $table->dropColumn('clase_grupal_id');
        });
    }
}
