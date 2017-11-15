<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddBooleanVistoNotasAdministrativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('notas_administrativas', function (Blueprint $table) {
            $table->boolean('boolean_visto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notas_administrativas', function (Blueprint $table) {
            $table->dropColumn('boolean_visto');
        });
    }
}
