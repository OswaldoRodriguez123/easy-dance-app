<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConfigClasesPersonalizadasNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config_clases_personalizadas', function (Blueprint $table) {

            $table->string('descripcion', 2000)->change();
            $table->string('ventajas', 2000)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config_clases_personalizadas', function (Blueprint $table) {
            $table->string('descripcion', 1000)->change();
            $table->string('ventajas', 1000)->change();
        });
    }
}
