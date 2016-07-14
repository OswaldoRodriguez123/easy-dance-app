<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCampanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campanas', function (Blueprint $table) {
            $table->string('historia', 1000)->change();
            $table->string('presentacion', 1000)->after('imagen');
            $table->string('imagen_presentacion',50)->after('imagen');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campanas', function (Blueprint $table) {
            $table->string('historia')->change();
            $table->dropColumn('presentacion');
            $table->dropColumn('imagen_presentacion');
        });
    }
}
