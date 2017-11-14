<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddImagenHorizontalAcademiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('academias', function (Blueprint $table) {
            $table->string('imagen_horizontal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academias', function (Blueprint $table) {
            $table->dropColumn('imagen_horizontal');
        });
    }
}
